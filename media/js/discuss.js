(function ($){

	var win = $(window),
		new_message = $('.new_message'),
		cloud_links = $('#cloud_thumbs .caption a, #cloud_thumbs .img_wrap'),
		more_details = function (){
			var self = $(this), button = self.next(), height = self.height(),
				collapse_height = self.attr('data-height'), links = self.find('.body h4 a').add(cloud_links.not('.img_wrap'));

			if(height > parseInt(collapse_height)) {
				button.bind('click.details', (function (){
					if(button.hasClass('close')) {
						self.stop().animate({'height': collapse_height}, 400);
						button.attr('title', 'Ouvrir');
					}
					else {
						self.stop().animate({'height': height}, 400);
						button.attr('title', 'Fermer');
					}

					button.toggleClass('open close');

					return false;
				}));

				self.css({height: collapse_height});
				button.addClass('open');
			}
			else {
				button.hide();
			}

			links.each(function (){
				var self = $(this), next = self.parent().next();
				if(self.text().length > 20){
					self.text($.trim(self.text().substr(0, 20)) + '...');
				}

				if(next.text().length > 20){
					next.text($.trim(next.text().substr(0, 20)) + '...');
				}
			});
		},

		more_details_unbind = function (){
			$(this).css('height', '').next().unbind('click.details');
		};

	// popin plugin
	(function (){
		contents = {};

		$.fn.Popit = function () {
			var body = $('body'), loading = $('<div class="loading" />');

			return this.each(function (){

				var fade = $('<div id="popin_fade" />'),
					popin = $('<div id="popin" />'),
					close_button = $('<a id="popin_close" title="fermer" href="#" />'),
					scroll,

					close = function (){
						fade.hide().detach();
						popin.hide().detach();
						close_button.hide().detach();
						window.scrollTo(0, scroll);

						return false;
					},

					self = $(this),
					is_url = (self.attr('rel') == 'url'),
					is_image = (self.attr('rel') == 'image'),
					content = (!is_url && !is_image) ? $(self.attr('href')) : loading,

					show = function (){
						fade.show();
						popin.show().html(content);;
						close_button.show();
						body.append(fade).append(popin).append(close_button);

						scroll = win.scrollTop();
						window.scrollTo(0, 0);
					};

				close_button.click(close);
				fade.click(close).css({opacity:0.4});

				if(!is_url && !is_image && !content.length) return;

				self.click(function (){
					if(is_url && !self.data('loaded')) {
						$.get(self.attr('href'), function (resp){
							content = resp;
							self.data('loaded', true);
							popin.html(content);
						}).error(function (){
							alert("Une erreur est survenu, essayez encore ou contactez l'administrateur.");
							close();
						});
					}
					else if(is_image && !self.data('loaded')) {
						$('<img />').load(function (){
							self.data('loaded', true);
							content = $(this);
							popin.html(content);
						}).attr('src', self.attr('href'));
					}

					show();

					return false;
				});

			});
		};
	})();

	// details
	(function (){
		var details = $('.details .wrap'),
			parent = details.parent(),

			fixed_details = $('.fixed_details'),

			h2 = details.find('h2').add(fixed_details.find('h2')),

			go_top = $('.go_top');

		win.scroll(function (){
			if(win.scrollTop() >= parent.offset().top + parent.outerHeight()) {
				fixed_details.show();
				go_top.show();
			}
			else {
				fixed_details.hide();
				go_top.hide();
			}
		});

		go_top.click(function (){
			$('html, body').animate({scrollTop: 0});
			return false;
		});

		win.scroll();

		h2.each(function (){
			var self = $(this);
			if(self.text().length > 25){
				self.text($.trim(self.text().substr(0, 25)) + '...');
			}
		});

		details.add($('.discussion .wrap')).each(more_details);

	})();

	// editor display
	(function (){
		var target = $(new_message.attr('href')), messages = $('#messages'), hidden = true;
		new_message.click(function (){
			if(hidden) {
				target.show();
				new_message.html('Fermer');
				hidden = false;
			}
			else {
				target.hide();
				new_message.html('Nouveau Message');
				hidden = true;
			}

			return false
		});

		target.hide();

	})();

	// create fake input file
	(function () {
		$('.fake_file').each(function (){

			var self = $(this).css({position:'relative'}),
				val = self.find('.value'),
				file = self.find('input').css({opacity:0, display:'block', position:'absolute', zIndex:5000, width:50, height:50}),
				upload = self.find('.upload'),
				i = 0;

			self.append(file);

			self.mousemove(function (e){
				file.css({top:e.pageY - self.offset().top -10, left:e.pageX - self.offset().left - 10});
				return false;
			});

			file.mousemove(function (e){
				file.css({top:e.pageY - self.offset().top -10, left:e.pageX - self.offset().left - 10});
				return false;
			});

			file.change(function (){
				val.html(file.val());
			});
		});

	})();

	$('.add_file, .add_link, .add_image, .add_video, .invite, .discussion a.popin').add(cloud_links).Popit();

	// details dropdown
	(function (){
		$('.dropdown').each(function (){

			var button = $(this), content = $(button.attr('href')), links = content.find('a');

			button.click(function (){
				button.toggleClass('dropdown_active');
				content.toggle();
				return false;
			});

			$(document).add(content).add(links).click(function (){
				button.removeClass('dropdown_active');
				content.hide();
			});

		});
	})();

	// tabs
	(function (){
		var tabs = $('.tabs, #cloud .controls .right');

		tabs.each(function (){
			var links = $(this).find('a'), contents;

			links.each(function (){
				var self = $(this);

				contents = (!contents) ? $(self.attr('href')) : contents.add($(self.attr('href')));

				self.click(function (){
					contents.removeClass('active').hide();
					contents.filter(self.attr('href')).show().addClass('active');

					if(self.attr('href') == '#cloud') {
						new_message.hide();
                        loadContent('#cloud','/mod/enlightn/ajax/get_my_cloud.php?limit=100&context=cloud_embed&guid='  + $('#guid').val());
                    } else
						new_message.show();

					if(self.hasClass('list')) {
						links.removeClass('thumbs_active');
						self.addClass('list_active');
					}
					else if(self.hasClass('thumbs')) {
						links.removeClass('list_active');
						self.addClass('thumbs_active');
					}

					links.removeClass('active');
					self.addClass('active');

					return false;
				});
			});

			contents.removeClass('active').hide();
			links.removeClass('active');
			links.eq(0).click();
		});
	})();

	// editor
	(function () {
		var discussion = $('.discussion'), ck, ckfield, config = {
			toolbarStartupExpanded : false,
			toolbar:
			[
				['Bold', 'Italic', 'Underline', 'Font', 'FontSize', 'TextColor', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
			]
		};

		ckfield = $('.cke_textarea');
		/*ck =  ckfield.ckeditor(config).ckeditorGet();

		$('form#new_message').on('reset', function (){ ck.setData(''); ck.focus(); })
			.on('submit', function (){
				$.post($(this).attr('action'), {message:ck.getData()}, function (resp){

					ck.setData('');
					ck.focus();
					discussion.prepend(resp);
					$('.discussion a.popin').unbind('click').Popit();
					$('.discussion .wrap').each(more_details_unbind).each(more_details);
					console.log($('.discussion .wrap'));
				}).error(function (){
					alert("Une erreur est survenu, essayez encore ou contactez l'administrateur.");
				});

				return false;
			});*/
	})();

	// cloud list
	(function (){
		$('#cloud .collapse').each(function (){
			var button = $(this), content = button.next();

			button.click(function (){
				content.toggle();
				button.toggleClass('ico_collapse_close ico_collapse_open');
				return false;
			});

			content.hide();
			button.toggleClass('ico_collapse_close ico_collapse_open');
		});

	})();

	$('#wrapper').removeClass('no-js');

})(jQuery);