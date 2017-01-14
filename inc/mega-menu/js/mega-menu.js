var menuSettings;

(function ($, _) {
	'use strict';

	var options;
	options = menuSettings = {
		init: function () {
			options.$body = $('body');
			options.$modal = $('#menu-modal');
			options.itemData = {};
			options.templates = {
				menus     : _.template($('#pp-tmpl-menus').html()),
				title     : _.template($('#pp-tmpl-title').html()),
				mega      : _.template($('#pp-tmpl-mega').html()),
				background: _.template($('#pp-tmpl-background').html()),
				icon      : _.template($('#pp-tmpl-icon').html()),
				content   : _.template($('#pp-tmpl-content').html()),
				general   : _.template($('#pp-tmpl-general').html())
			};

			options.frame = wp.media({
				library: {
					type: 'image'
				}
			});

			this.initActions();
		},

		initActions: function () {
			options.$body
				.on('click', '.opensettings', this.openModal)
				.on('click', '.mega-modal-backdrop, .mega-modal-close, .pp-button-cancel', this.closeModal);

			options.$modal
				.on('click', '.pp-mega-menu-item-setting-tab a', this.switchPanel)
				.on('click', '.item-controls span', this.resizeMegaColumn)
				.on('click', '.pp-button-save', this.saveChanges);
		},

		openModal: function () {
			options.getItemData(this);

			options.$modal.show();
			options.$body.addClass('modal-open');
			options.render(this);

			return false;
		},

		closeModal: function () {
			options.$modal.hide().find('.pp-menu-item-tab-content').html('');
			options.$body.removeClass('modal-open');
			return false;
		},

		switchPanel: function (e) {
			e.preventDefault();

			var $el = $(this).parent(),
				panel = $el.data('panel');

			$el.addClass('active-item-setting-tab').siblings('.active-item-setting-tab').removeClass('active-item-setting-tab');
			options.openSettings(panel);
		},

		render: function (menuItem) {
			// Render menu
			options.$modal.find('.pp-mega-menu-item-setting-tabs').html(options.templates.menus(options.itemData));

			var $activeMenu = options.$modal.find('.pp-mega-menu-item-setting-tabs .active-item-setting-tab');

			// Render title
			var title = $(menuItem).parents('.menu-item-settings').find('input.edit-menu-item-title').val();
			options.$modal.find('.pp-mega-menu-item-header-bar').html(options.templates.title({title: title}));

			// Render content
			this.openSettings($activeMenu.data('panel'));
		},

		openSettings: function (panel) {
			var $content = options.$modal.find('.pp-menu-item-tab-content'),
				$panel = $content.children('#inside-' + panel);

			if ($panel.length) {
				$panel.addClass('active').siblings().removeClass('active');
			} else {
				$content.append(options.templates[panel](options.itemData));
				$content.children('#inside-' + panel).addClass('active').siblings().removeClass('active');

				if ('mega' == panel) {
					options.initMegaColumns();
				}
				if ('background' == panel) {
					options.initBackgroundFields();
				}
				if ('icon' == panel) {
					options.initIconFields();
				}
			}
		},

		resizeMegaColumn: function (e) {
			e.preventDefault();

			var steps = ['20.00%', '25.00%', '33.33%', '50.00%', '66.66%', '75.00%', '100.00%'],
				$el = $(this),
				$column = $el.closest('.menu-item-container'),
				width = $column.data('width'),
				current = _.indexOf(steps, width),
				next;

			if (-1 === current) {
				return;
			}

			if ($el.hasClass('submenu-bigger')) {
				next = current == steps.length ? current : current + 1;
			} else {
				next = current == 0 ? current : current - 1;
			}

			$column[0].style.width = steps[next];
			$column.data('width', steps[next]);
			$column.find('.menu-item-handle .menu-item-width').val(steps[next]);
		},

		initMegaColumns: function () {
			var $columns = options.$modal.find('#inside-mega .menu-item-container'),
				defaultWidth = '25.00%';

			if (!$columns.length) {
				return;
			}

			// Support maximum 4 columns
			if ($columns.length < 4) {
				defaultWidth = String(( 100 / $columns.length ).toFixed(2)) + '%';
			}

			_.each($columns, function (column) {
				var width = column.dataset.width;

				width = width || defaultWidth;

				column.style.width = width;
				column.dataset.width = width;
				$(column).find('.menu-item-handle .menu-item-width').val(width);
			});
		},

		initBackgroundFields: function () {
			options.$modal.find('.background-color-picker').wpColorPicker();

			// Background image
			options.$modal.on('click', '.item-media .upload-button', function (e) {
				e.preventDefault();

				var $el = $(this);

				// Remove all attached 'select' event
				options.frame.off('select');

				// Update inputs when select image
				options.frame.on('select', function () {
					// Update input value for single image selection
					var url = options.frame.state().get('selection').first().toJSON().url;

					$el.siblings('.thumbnail-image').html('<img src="' + url + '">');
					$el.siblings('input').val(url);
					$el.addClass('hidden');
					$el.siblings('.remove-button').removeClass('hidden');
				});

				options.frame.open();
			}).on('click', '.item-media .remove-button', function (e) {
				e.preventDefault();

				var $el = $(this);

				$el.siblings('.thumbnail-image').html('');
				$el.siblings('input').val('');
				$el.addClass('hidden');
				$el.siblings('.upload-button').removeClass('hidden');
			});

			// Image type
			options.$modal.on('change', '.image-size select', function () {
				var $el = $(this),
					$container = $el.parents('.inside-background');

				if ('background' == $el.val()) {
					$container.find('.background-position, .background-repeat, .background-attachment').removeClass('hidden');
					$container.find('.image-position').addClass('hidden');
				} else {
					$container.find('.background-position, .background-repeat, .background-attachment').addClass('hidden');
					$container.find('.image-position').removeClass('hidden');
				}
			});
		},

		initIconFields: function () {
			var $input = options.$modal.find('#pp-icon-input'),
				$preview = options.$modal.find('.pp-icon-selector .selected-icon'),
				$icons = options.$modal.find('.pp-icon-selector .icons-content i');

			// Select an icon
			options.$modal.on('click', '.pp-icon-selector .icons-content span', function () {
				var $el = $(this),
					icon = $el.find('i').data('icon');

				$('.pp-icon-selector .icons-content span.active').removeClass('active');
				$el.addClass('active');

				$input.val(icon);
				$preview.html('<i class="' + icon + '"></i>');
			});

			// Delete the selected icon
			options.$modal.on('click', '.pp-icon-selector .remove-icon', function () {
				$preview.html('');
				$input.val('');
			});

			// Tab icons
			options.$modal.on('click', '.pp-icon-selector .icons-tab', function () {
				var $el = $(this),
					$target = $('.pp-icon-selector .icons-content.' + $el.data('tab') );

				if (!$el.hasClass('active')){
					$el.addClass('active').siblings('.active').removeClass('active');
					$target.addClass('active').siblings('.active').removeClass('active');
				}
			});

			// Search for icons
			options.$modal.on('keyup', '.pp-icon-search', function (e) {
				var term = $(this).val().toUpperCase(),
					$iconContainer = $icons.parent();

				if (!term) {
					$iconContainer.show();
				} else {
					$iconContainer.hide().filter(function () {
						return $(this).find('i').data('icon').toUpperCase().indexOf(term) > -1;
					}).show();
				}
			});
		},

		getItemData: function (menuItem) {
			var $menuItem = $(menuItem).closest('li.menu-item'),
				$menuData = $menuItem.find('.pp-data'),
				children = $menuItem.childMenuItems();

			options.itemData = {
				depth          : $menuItem.menuItemDepth(),
				megaData       : {
					mega         		: $menuData.data('mega'),
					mega_width   		: $menuData.data('mega_width'),
					width        		: $menuData.data('width'),
					background   		: $menuData.data('background'),
					img_type			: $menuData.data('img_type'),
					img_size			: $menuData.data('img_size'),
					img_pos				: $menuData.data('img_pos'),
					icon         		: $menuData.data('icon'),
					hide_text     		: $menuData.data('hide_text'),
					hide_desktop  		: $menuData.data('hide_desktop'),
					hide_mobile   		: $menuData.data('hide_mobile'),
					hide_img_desktop  	: $menuData.data('hide_img_desktop'),
					hide_img_mobile  	 : $menuData.data('hide_img_mobile'),
					hot          		: $menuData.data('hot'),
					uppercase_text		: $menuData.data('uppercase_text'),
					new          		: $menuData.data('new'),
					trending     		: $menuData.data('trending'),
					sale     			: $menuData.data('sale'),
					disable_link  		: $menuData.data('disable_link'),
					content      		: $menuData.html()
				},
				data           : $menuItem.getItemData(),
				children       : [],
				originalElement: $menuItem.get(0)
			};

			if (!_.isEmpty(children)) {
				_.each(children, function (item) {
					var $item = $(item),
						$itemData = $item.find('.pp-data'),
						depth = $item.menuItemDepth();

					options.itemData.children.push({
						depth          : depth,
						subDepth       : depth - options.itemData.depth - 1,
						data           : $item.getItemData(),
						megaData       : {
							mega         		: $itemData.data('mega'),
							mega_width   		: $itemData.data('mega_width'),
							width        		: $itemData.data('width'),
							background   		: $itemData.data('background'),
							img_type		   	: $itemData.data('img_type'),
							img_size		   	: $itemData.data('img_size'),
							img_pos		   		: $itemData.data('img_pos'),
							icon         		: $itemData.data('icon'),
							hide_text     		: $itemData.data('hide_text'),
							hide_desktop  		: $itemData.data('hide_desktop'),
							hide_mobile   		: $itemData.data('hide_mobile'),
							hide_img_desktop 	: $itemData.data('hide_img_desktop'),
							hide_img_mobile   	: $itemData.data('hide_img_mobile'),
							hot          		: $itemData.data('hot'),
							uppercase_text		: $itemData.data('uppercase_text'),
							new          		: $itemData.data('new'),
							trending     		: $itemData.data('trending'),
							sale     			: $itemData.data('sale'),
							disable_link  		: $itemData.data('disable_link'),
							content      		: $itemData.html()
						},
						originalElement: item
					});
				});
			}

		},

		setItemData: function (item, data, depth) {
			var checkboxes = ['mega', 'hide_text', 'uppercase_text', 'disable_link', 'hide_desktop', 'hide_mobile', 'hot', 'new', 'trending', 'sale', 'hide_img_desktop', 'hide_img_mobile'];

			// Set the checkboxes to false if does not exist in the data
			$.each(checkboxes, function(index, value){
				if (!_.has(data, value)) {
					data[value] = false;
				}
			});

			var $dataHolder = $(item).find('.pp-data');

			if (_.has(data, 'content')) {
				$dataHolder.html(data.content);
				delete data.content;
			}

			$dataHolder.data(data);

		},

		getFieldName: function (name, id) {
			name = name.split('.');
			name = '[' + name.join('][') + ']';

			return 'menu-item[' + id + ']' + name;
		},

		saveChanges: function () {
			var data = options.$modal.find('.pp-menu-item-tab-content :input').serialize(),
				$spinner = options.$modal.find('.pp-mega-menu-item-controls .spinner');

			$spinner.addClass('is-active');

			$.post(ajaxurl, {
				action: 'pp_save_menu_item_data',
				data  : data
			}, function (res) {
				if (!res.success) {
					return;
				}

				var data = res.data['menu-item'];

				// Update parent menu item
				if (_.has(data, options.itemData.data['menu-item-db-id'])) {
					options.setItemData(options.itemData.originalElement, data[options.itemData.data['menu-item-db-id']], 0);
				}

				_.each(options.itemData.children, function (menuItem) {
					if (!_.has(data, menuItem.data['menu-item-db-id'])) {
						return;
					}

					options.setItemData(menuItem.originalElement, data[menuItem.data['menu-item-db-id']], 1);
				});

				$spinner.removeClass('is-active');
				options.closeModal();
			});
		}
	};

	$(function () {
		menuSettings.init();
	});
})(jQuery, _);
