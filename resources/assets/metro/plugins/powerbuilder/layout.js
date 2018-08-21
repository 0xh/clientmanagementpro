jQuery(document).ready(function($){

	$.widget('metroskin.layoutbuilder',{

		options: {},

		layoutbuilder: {},

		_setOption: function(){

		},

		_create: function(){

			var that = this;
			var layout_preview = $('#layout_preview');

			$('#add_row').on('click',function(){
				var counter = $('.row', layout_preview).length;

				var a = $.zc('div.cells.row>div.cell{-- cell content --}');

				a.appendTo(layout_preview);
				layout_preview.data('row', counter);

				$('.row', layout_preview).removeClass('bd-cyan active-row');
				$('.cell', layout_preview).removeClass('bd-cobalt active-cell');

				$(layout_preview).find('.row').eq( counter ).addClass('bd-cyan active-row');
				$(layout_preview).find('.row').eq( counter ).find('.cell').addClass('bd-cobalt active-cell');

			})

			$('#min_row').on('click', function(){
				$(layout_preview).find('.row.active-row').remove();
			})

			$('#add_col').on('click', function(){
				var active_row = $(layout_preview).find('.row.active-row');

				var b = $.zc('div.cell{-- cell content --}');

				if( active_row.find('.cell').length < 8 ){
					$(b).appendTo( active_row );
				}
			})

			$('#min_col').on('click',function(){
				var active_row = $(layout_preview).find('.row.active-row');

				if( active_row.find('.cell').length > 1 ){
					active_row.find('.cell.active-cell').remove();
				} 
			})

			// click row
			$(layout_preview).delegate( $('.row'),'click',function(e){
				var el = e.toElement;
				if( ! $(el).hasClass('row')){
					return false;
				}

				var idx = $('.row', layout_preview).index( $(e.toElement));
				$(layout_preview).data('row', idx );
				$('.row', layout_preview).removeClass('bd-cyan active-row');
				$(layout_preview).find('.row').eq( idx ).addClass('bd-cyan active-row');
			})

			// click cell
			$(layout_preview).delegate( $('.cell'),'click',function(e){

				var el       = e.toElement;
				if( ! $(el).hasClass('cell')){
					return false;
				}

				var cell_idx = $('.row .cell', layout_preview).index( el );
				var row_idx  = $('.row', layout_preview).index( $(el).parent('.row'));

				$(layout_preview).data('row', row_idx );
				$('.row', layout_preview).removeClass('bd-cyan active-row');
				$(layout_preview).find('.row').eq( row_idx ).addClass('bd-cyan active-row');

				$('.row .cell', layout_preview).removeClass('bd-cobalt active-cell');
				$('.row .cell', layout_preview).eq( cell_idx ).addClass('bd-cobalt active-cell');

				$('#panel_title').val( $('.heading .title',$(el)).text() );

				$('*', $(el)).each(function(){
					$(this).removeAttr('html');
				})

				$('#cell_content').val( html_beautify($(el).html()) )
				$('#panel_content').val( html_beautify($('.content .text', $(el)).html()) );
				
				$('#cell_class').val( $(el).attr('class'));
				$('#row_class').val( $(el).parent('.row').attr('class'));


			})


			$('#show_code').on('click',function(){
				$('#code_build').toggleClass('hide');
			})


			$('.btn-layout').on('click',function(){
				
				var idx    = $(layout_preview).data('row');
				var repeat = $(this).data('repeat');

				if( $(this).data('repeat')!=undefined ){
					var t_htm  = $(this).data('cell');
					var cell   = '';

					for(var i=0;i<repeat;i++){
						cell += t_htm + '+';

					}
					cell    = cell.substr(0, (cell.length -1) );
					var htm = $.zc( cell );
				}else{
					var htm = $.zc( $(this).data('cell') );
				}

				var rm_cls = 'cells cells2 cells3 cells4 cells5 cells6 cells7 cells8 cells9 cells10 cells11 cells12';

				var row = $(layout_preview).find('.row').eq(idx);
				$(row).removeClass( rm_cls ).addClass( $(this).data('row') ).html(htm);

			})


			$('#reset_col').on('click',function(){

				var idx    = $(layout_preview).data('row');
				var rm_cls = 'cells cells2 cells3 cells4 cells5 cells6 cells7 cells8 cells9 cells10 cells11 cells12';
				var row    = $(layout_preview).find('.row').eq(idx);
				$(row).removeClass( rm_cls ).addClass( 'cells' );

			})


			$('[data-role="button-check"]').each(function(){
				$(this).prepend( $.zc('span.icon.fa.fa-square-o'));
			})


			$('[data-role="button-check"]').on('click',function(){
				if($(this).data('is_checked')==undefined){$(this).data('is_checked',false);}

				if( ($(this).data('is_checked')) == true ) {
					$(this).data('is_checked',false);
					$(this).find('.icon').attr('class','icon fa fa-square-o');
				}else{
					$(this).data('is_checked',true);
					$(this).find('.icon').attr('class','icon fa fa-check-square');
				}
			})


			$.each(metro_color, function(i,e){
				$('#panel_title_bg li').append('<div class="color-box bg-'+i+' " data-color="'+i+'" ></div>');
			})


			$('#panel_title_bg li .color-box').on('click',function(){
				var a     = $(this).parents('ul').prev().find('.icon');
				var color = $(this).data('color');
				var cell  = $(layout_preview).find('.active-cell');

				$(a).attr('class','icon fa fa-paint-brush fg-'+color);
				$(cell).find('.panel>.heading').attr('class','heading bg-'+color);

			})


			$('#is_panel').on('click',function(e){
				var cell = $('.active-cell', layout_preview);

				if( $(cell).find('.panel').length == 0){
					htm_panel = $.zc('div.panel.widget-box>((div.heading>div.title{Panel Title})+(div.content>div.text{-- panel content --}))');

					$(cell).html( htm_panel )
				} else {
					$(cell).html('-- cell content --');
				}
			})


			$('#is_collapse').on('click',function(e){
				var cell = $('.active-cell', layout_preview);

				if ($(cell).find('.panel').attr('data-role')!='panel') {
					$(cell).find('.panel').attr('data-role','panel').addClass('collapsible');
				}else{
					$(cell).find('.panel').attr('data-role','').removeClass('collapsible');
				};

			})


			$('#panel_title').on('keyup',function(){
				var cell = $(layout_preview).find('.active-cell');

				$(cell).find('.heading .title').text( $(this).val() );
			})


			$('#panel_content').on('blur',function(){
				var cell = $(layout_preview).find('.active-cell');

				$(cell).find('.content .text').html( $(this).val());
			})


			$('#cell_class').on('blur',function(){
				var cell = $('.active-cell', layout_preview);
				$(cell).attr('class', $(this).val());
				$(this).parents('.d-menu').prev().trigger('click');
			})


			$('#cell_content').on('blur',function(){
				var cell = $('.active-cell', layout_preview);
				$(cell).html($(this).val());
			})


			$('#row_class').on('blur',function(){
				var row = $('.active-row', layout_preview);
				$(row).attr('class', $(this).val());
				$(this).parents('.d-menu').prev().trigger('click');
			})


			$('.dropdown-toggle').on('click',function(){
				var dmenu = $(this).next();
				if(dmenu.data('role')!='dropdown-keep'){
					return false;
				}
				$('[data-role="dropdown-keep"]').not( $(dmenu) ).slideUp();
				$(dmenu).slideToggle();
			})


			// zen input
			$('#zen_input').on('blur',function(){
				if(!$(this).val()){
					$('#zen_output').val('');
				}
				var html = HTML.query('#zen_area');
				html.innerHTML = '';
				html.add( $(this).val());
				$('#zen_output').val( html_beautify( $('#zen_area').html() ) );
			})


			// build code
			$('#build_code').on('click',function(){

				var p = $(layout_preview).html().replace(/^\s+/,'');
				var b = $.zc('div>div.grid');
				$(b).find('.grid').append(p);

				console.log($(b).html());

				$('*', $(b) ).removeAttr('html');

				$('.cell',$(b)).each(function(i,o){
					var css_cell = $(this).attr('class');
					css_cell = css_cell.replace(/bd-\w+/,'').replace('active-cell','');
					$(this).attr('class', css_cell);
				})


				$('.row', $(b)).removeClass('bd-cyan active-row');

				t = $(b).html();

				$('#text_code').val( html_beautify(t) );
				
			})


		},

		_destroy: function(){

		}

	})

	
	$('#layout_preview').layoutbuilder();



})


