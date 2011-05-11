<?php


class Embed_url {

	var $url;
	var $hostname;
	var $title;
	var $html;
	var $description;
	var $tags;
	var $images;
	var $sortedImage;
	var $dom;

	function __construct($args = array()) {

		if ($args['url']) {
        	$this->url = $this->checkValues($args['url']);
		}
       	$this->hostname = $this->getDomainName($args['url']);
       	$this->dom		= new DOMDocument();
	}

	public function embed () {
		$this->fetchRecord();
		$this->getTags();
		$this->getTitle();
		$this->getDescription();
		$this->getImages();
		$this->sortImages();
	}

	private function checkValues($value) {
		$value = trim($value);
		if (get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		$value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
		$value = strip_tags($value);
		$value = htmlspecialchars($value);
		return $value;
	}

	private function getDomainName ($url) {
		preg_match('@^(?:http://)?([^/]+)@i', $url, $url_host);
		$host = $url_host[1];
		// get last two segments of host name
		preg_match('/[^.]+\.[^.]+$/', $host, $url_host);
		return $url_host[0];
	}


	private function fetchRecord () {
		$data = file_get_contents($this->url);
		$this->html =  $data;
	}

	private function getTitle () {
		if (isset($this->tags['title'])) {
			$this->title = $this->tags['title'];
		} else {
			$title_regex = "/<title>(.+)<\/title>/i";
			preg_match_all($title_regex, $this->html, $title, PREG_PATTERN_ORDER);
			$this->title = $title[1][0];
		}
	}

	private function getTags () {
		$this->tags = get_meta_tags($this->url);
	}

	private function getDescription () {
		$this->description = $this->tags['description'];
	}

	private function getImages () {
		$this->dom->loadHTML($this->html);
		$elements = $this->dom->getElementsByTagName('meta');
		if (!is_null($elements)) {
			foreach ($elements as $element) {
				if($element->getAttribute('property') == 'og:image') {
					$this->images['image'] = $element->getAttribute('content');
					return;
				}
			}
		 }		
		$image_regex = '/<img[^>]*'.'src=[\"|\'](.*)[\"|\']/Ui';
		preg_match_all($image_regex, $this->html, $img, PREG_PATTERN_ORDER);
		$this->images = $img[1];
	}

	private function sortImages () {
		if (isset($this->images['image'])) {
			$this->sortedImage[] =$this->images['image'];
			return;
		}
		$c=sizeof($this->images);
		for ($i=0;$i<=$c;$i++) {
			$this->images[$i] = $this->chroot($this->images[$i]);
			if(@$this->images[$i]
					&& $this->isImageId($this->images[$i])
					&& $this->isRelatedImage($this->images[$i]) > 40) {
				$image_data = @getimagesize(@$this->images[$i]);
				if(@$image_data) {
					list($width, $height, $type, $attr) = $image_data;
					if($width >= 50 && $height >= 50 ){
						$this->sortedImage[] = $this->images[$i];
					}
				}
			}
		}
	}

	private function isImageId ($image) {
		return preg_match('/\d{5,10}/i',$image);
	}

	private function isRelatedImage ($image) {
		similar_text($this->url,$image, $is_image_related);
		return $is_image_related;
	}

	private function chroot($image) {
		if (substr($image,0,1) == '/') {
			 $parsed_url = parse_url($this->url);
			 //var_dump($parsed_url);
			 return $parsed_url['scheme'] . '://' . $parsed_url['host'] . $image;
		}
		return $image;
	}
}
?>