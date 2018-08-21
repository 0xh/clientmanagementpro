
var metro_color = {
	black       : "#000000",
	white       : "#ffffff",
	lime        : "#a4c400",
	green       : "#60a917",
	emerald     : "#008a00",
	teal        : "#00aba9",
	blue        : "#00aff0",
	cyan        : "#1ba1e2",
	cobalt      : "#0050ef",
	indigo      : "#6a00ff",
	violet      : "#aa00ff",

	pink        : "#dc4fad",
	magenta     : "#d80073",
	crimson     : "#a20025",
	red         : "#ce352c",
	orange      : "#fa6800",
	amber       : "#f0a30a",
	yellow      : "#e3c800",
	brown       : "#825a2c",
	olive       : "#6d8764",

	steel       : "#647687",
	mauve       : "#76608a",
	taupe       : "#87794e",
	gray        : "#555555",
	dark        : "#333333",
	darker      : "#222222",
	darkBrown   : "#63362f",
	darkCrimson : "#640024",

	darkMagenta : "#81003c",
	darkIndigo  : "#4b0096",
	darkCyan    : "#1b6eae",
	darkCobalt  : "#00356a",
	darkTeal    : "#004050",
	darkEmerald : "#003e00",

	darkGreen   : "#128023",
	darkOrange  : "#bf5a15",
	darkRed     : "#9a1616",
	darkPink    : "#9a165a",
	darkViolet  : "#57169a",
	darkBlue    : "#16499a",

	lightBlue   : "#4390df",
	lightRed    : "#da5a53",
	lightGreen  : "#7ad61d",
	lighterBlue : "#00ccff",
	lightTeal   : "#45fffd",
	lightOlive  : "#78aa1c",

	lightOrange : "#ffc194",
	lightPink   : "#f472d0",
	grayDark    : "#333333",
	grayDarker  : "#222222",
	grayLight   : "#999999",
	grayLighter : "#eeeeee",
};

// run yield first
jQuery(document).ready(function($){
	$('[data-role="yield"]').each(function(){
		$(this).html( $('yield#'+$(this).data('source')).html());
		$('yield#'+$(this).data('source')).remove();

	})

	init();

})

function init(){
		
	window_load();

	$(window).on('scroll',function(){

		var widget_sidebar_height      = $('.widget-sidebar').outerHeight() ;
		var content_wrapper_alt_height = widget_sidebar_height + $('.page-heading').height();

		$('.content-wrapper').css('min-height', Math.max( $('.sidebar-wrapper').outerHeight(),  content_wrapper_alt_height + 2 ));
		
		$('.widget-sidebar').css('min-height', widget_sidebar_height );
	})

	if( "undefined"!= typeof WOW ){
		new WOW().init();
	}
	
	$('.sidebar-sizer').on('click', function(){
		$('.page-container').toggleClass('sidebar-compact');
		$('.sidebar-wrapper').toggleClass('hidden');
		if( !$('.sidebar-wrapper').hasClass('hidden')){
			$('.active-container .d-menu', $(this)).css('display','block');
		}
	})


	$(window).on('resize',function(){
		var tbl_res_wd = $(window).width() - 130;
		// $('.table-responsive').width( tbl_res_wd ).parents('.cell').width(tbl_res_wd + 30 );
		$('.chartjs-content > canvas').width(tbl_res_wd);

	})


}


function window_load(){
	if( $(window).width() < 800 ){
		// $('.page-container').addClass('sidebar-compact');

		var tbl_res_wd = $(window).width() - 130;
		// $('.table-responsive').width( tbl_res_wd ).parents('.cell').width(tbl_res_wd + 30 );
		$('.chartjs-content > canvas').width(tbl_res_wd);
		// $('.content-wrapper').width( ($(window).width() - 57) );


	} else {
		$('.page-container').removeClass('sidebar-compact');
	}


}

function showDialog( id ){
	var dialog = $(id).data('dialog');
	dialog.open();
};


String.prototype.ucFirst = function() {
		return this.charAt(0).toUpperCase() + this.slice(1);
}

$(function(){
		"use strict";

		setInterval(function(){
				$("h1 .nav-button").toggleClass('transform');
		}, 2000);
});

function fmtColor(color) {
		if (!color.id) { return color.text; }
		var $color = $(
				'<span><div class="color-select-frame place-left '+color.element.value+' " ></div>'+color.text+'</span>'
		);
		return $color;
}    

function fmtIcon(icon){
		if (!icon.id) { return icon.text; }
		var $icon = $(
				'<span><span class="icon '+icon.element.value+' " ></span> '+icon.text+'</span>'
		);
		return $icon;
}

function MetroConfirmRemove( url )
{
	if(confirm('Are u sure deleting this record ? '))
	{
		window.location.href = url;	
	}
	return false;
}
function MetroRemove(  )
{	
	var total = $('input[class="ids"]:checkbox:checked').length;
	if(confirm('are u sure removing selected rows ?'))
	{
			$('#MetroTable').submit();// do the rest here	
	}	
}	
function MetroDelete(){
	MetroRemove();
}
function MetroConfirmDelete( url ){
	MetroConfirmRemove( url )
}

function MetroModal( url , title)
{
	$('#metro-modal-content').html(' ....Loading content , please wait ...');
	$('.modal-title').html(title);
	$('#metro-modal-content').load(url,function(){
	});
	$('#metro-modal').modal('show');	
}



jQuery(document).ready(function($){

		$('body').delegate('.MetroModalOpener','click',function(e){
			e.preventDefault();
			if( $(this).attr('action')=='' ) return false;
			MetroModal( $(this).data('action') , $(this).data('modaltitle') );
			
			return false;
		})
		

		$('.tile').click(function(){
			if( $(this).data('action') && $(this).data('action')!='#'){
				location.href=$(this).data('action');
			}
		})
		

		$('.checkall').click(function(){
			var ids = $(this).parents('form').find('.ids');
			if( $(this).is(':checked')){
				$(ids).prop('checked', true );
			} else {
				$(ids).prop('checked', false );
			}
		
		})
		
		$('body').delegate('.metro-confirm', 'click', function(e){
			e.preventDefault();
			if(  confirm( $(this).data('confirm') ) ){
				if( $(this).attr('href') )
					location.href = $(this).attr('href');
				if( $(this).data('target') )
					$( $(this).data('target') ).submit();
			}
		})
		

		if( $.fn.nanoScroller ){
			$('.nano').nanoScroller();
		}


		if( $.fn.fancybox ){

			$('a.previewImage').fancybox();	
			
			$('img[data-role="fancy-image"]').each(function(i){
				src = $(this).attr('src');
				$(this).wrap('<a href="'+src+'" class="previewImage" ></a>');
			})
			
			$('body').delegate('a[href="#"]','click',function(e){
				e.preventDefault();
			});

			$('.image-container[data-role="fancy-image"]').each(function(){
				var src = $(this).find('img').attr('src');
				$(this).find('.image-overlay').wrap('<a href="'+src+'" class="previewImage" ></a>');
			})

		}
		
		$('body').delegate('.todo-cb','click',function(){

			if($(this).is(':checked')){
				$(this).parent().find('.caption').addClass('todo-completed');
			}else{
				$(this).parent().find('.caption').removeClass('todo-completed');
			}

		})	


		/*plugin init*/

		if(undefined != $.fn.summernote ){
			$('.summernote').summernote();

			function summernote_h(){

				$('.summernote').next('.note-editor').each(function(i){
					editorHeight = $(this).height() - $('.note-toolbar', $(this)).outerHeight();
					$('.note-editing-area', $(this)).height( editorHeight );
				})

			}

			summernote_h();

			$(window).on('resize', function(){
				summernote_h();
			});

		}

		if( undefined != $.fn.jqte ){

			$('.jqte').jqte();

		}


		/* sparkline */
		if( undefined != $.fn.sparkline ){
			
			var blue        = "#348fe2",
				blueLight   = "#5da5e8",
				blueDark    = "#1993E4",
				aqua        = "#49b6d6",
				aquaLight   = "#6dc5de",
				aquaDark    = "#3a92ab",
				green       = "#00acac",
				greenLight  = "#33bdbd",
				greenDark   = "#008a8a",
				orange      = "#f59c1a",
				orangeLight = "#f7b048",
				orangeDark  = "#c47d15",
				dark        = "#2d353c",
				grey        = "#b6c2c9",
				purple      = "#727cb6",
				purpleLight = "#8e96c5",
				purpleDark  = "#5b6392",
				red         = "#ff5b57";

			var e = {
				height: "23px",
				width: "80px",
				fillColor: "transparent",
				lineWidth: 2,
				spotRadius: 4,
				highlightLineColor: blue,
				highlightSpotColor: blue,
				spotColor: false,
				minSpotColor: false,
				maxSpotColor: false,
				enableTagOptions: true,
			};
			
			$('.sparklines').sparkline('html', e )

			function tsparkline() {

				//var source           = [50,30,45,40,50,20,35,40,50,70,90,40];
				var source           = "html";
				e.type               = "line";
				e.height             = "23px";
				e.lineColor          = red;
				e.highlightLineColor = red;
				e.highlightSpotColor = red;

				var n = $(".sparkline-red").width();
				
				if (n >= 80) {
					e.width = "80px"
				} 
				/*else {
					e.width = "100%"
				}*/

				$(".sparkline-red").sparkline(source, e);
				
				e.lineColor = orange;
				e.highlightLineColor = orange;
				e.highlightSpotColor = orange;
				$(".sparkline-orange").sparkline(source, e);
				
				e.lineColor = green;
				e.highlightLineColor = green;
				e.highlightSpotColor = green;
				$(".sparkline-green").sparkline(source, e);
				
				e.lineColor = blue;
				e.highlightLineColor = blue;
				e.highlightSpotColor = blue;
				$(".sparkline-blue").sparkline(source, e);
				
				e.lineColor = grey;
				e.highlightLineColor = grey;
				e.highlightSpotColor = grey;
				$(".sparkline-grey").sparkline(source, e);
				
				e.lineColor = dark;
				e.highlightLineColor = dark;
				e.highlightSpotColor = grey;
				$(".sparkline-dark").sparkline(source, e)
			}

			tsparkline();
			
			$(window).on("resize", function() {
				$(".sparkline-red").empty();
				$(".sparkline-orange").empty();
				$(".sparkline-green").empty();
				$(".sparkline-grey").empty();
				$(".sparkline-dark").empty();
				$(".sparkline-blue").empty();
				tsparkline()
			})

			
		}


		if( undefined != $.fn.peity){

			$('.peity-chart').each(function(e){
				var t = $(this);
				ptype = t.data('type')?t.data('type'):'line';
				
				var option = {};

				var width       = (t.data('width'))? {"width": t.data('width')}:{} ;
				var height      = (t.data('height'))? {"height": t.data('height')}:{} ;
				var radius      = (t.data('radius'))? {"radius": t.data('radius')}:{};
				var innerradius = (t.data('innerradius'))? {"innerRadius": t.data('innerradius')}:{};
				var stroke      = (t.data('stroke'))? {"stroke": t.data('stroke')}:{} ;
				var strokewidth = (t.data('strokewidth'))? {"strokeWidth": t.data('strokewidth')}:{} ;
				var padding     = (t.data('padding'))? {"padding": t.data('padding')}:{} ;
				var max         = (t.data('max'))? {"max": t.data('max')}:{} ;
				var min         = (t.data('min'))? {"min": t.data('min')}:{} ;
				// var fill         = (t.data('fill'))? {"fill": t.data('fill')}:{} ;
				var fill         = {} || $.parseJSON(t.data('fill'));

				// console.log( t.data('fill') );

				$.extend( option , {} , width, height, radius, innerradius, stroke , strokewidth, padding, max, min , fill );
				
				$(this).peity( ptype , option );
			})

		}

		/* ion range slider */
		if( $.fn.ionRangeSlider ){

			$('[data-role="ionrange"]').each(function(i){

				var option = $(this).data('option');

				$(this).ionRangeSlider( option );

			})

		}

		if( $.fn.knob ){

			$('.knob').knob();
			$('.knob').removeClass('knob');

		}

		if( $.fn.tagsInput ){
			$('.tagsinput').tagsInput({"width":"auto","height":25});
		}

		if( $.fn.clockpicker  ){
			$('[data-role="clockpicker"]').clockpicker();
		}

		if( $.fn.colorpicker ){
			$('[data-role="colorpicker"]').colorpicker();
		}

		if( $.fn.spectrum ){
			$('[data-role="spectrum"]').spectrum({
				preferredFormat: "hex"});
		}

		if( typeof Switchery!="undefined" ){

			elem = document.querySelectorAll('.switchery');

			$(elem).each(function(i,o){
				var color;
				var t = $(o).data('type')?$(o).data('type'):'primary';

				if(t=='alert'){
					color='#ce352c';
				}else if(t=='info'){
					color='#59CDE2';
				}else if(t=='success'){
					color='#60A917';
				}else if(t=='warning'){
					color='#fa6800';
				}else{
					color='#2086BF';
				}

				var switchery = new Switchery( o , {color: color });

			})

		}

		if( $.fn.select2 ){

			$('[data-type="select2"]').select2();

		}
		

		if($.fn.shuffle) {
			// Shuffle
			// ================================
			var $grid   = $('#shuffle-cells'),
				$filter = $('#shuffle-filter'),
				$sort   = $('#shuffle-sort'),
				$sizer  = $grid.find('shuffle-sizer');
			
			// instatiate shuffle
			$grid.shuffle({
				itemSelector: '.cell',
				sizer: $sizer
			});

			// Filter options
			$filter.on('click', '.button', function () {
				var $this = $(this),
					isActive = $this.hasClass('primary'),
					group = isActive ? 'all' : $this.data('group');

				// Hide current label, show current label in title
				if (!isActive) {
					$('#shuffle-filter .primary').removeClass('primary');
				}

				$this.toggleClass('primary');

				// Filter elements
				$grid.shuffle('shuffle', group);
			});

			// Sorting options
			$sort.on('change', function () {
				var sort = this.value,
					opts = {};

				// We're given the element wrapped in jQuery
				if (sort === 'date-created') {
					opts = {
						reverse: true,
						by: function ($el) {
							return $el.data('date-created');
						}
					};
				} else if (sort === 'title') {
					opts = {
						by: function ($el) {
							return $el.data('title').toLowerCase();
						}
					};
				}

				// Filter elements
				$grid.shuffle('sort', opts);
			});

			// Update shuffle on sidebar minimize/maximize
			$('html')
				.on('sidebar:resize', function () { $grid.shuffle('update'); });

			// trigger all button for first load
			$('#shuffle-filter').find('button:first').trigger('click');	
		};


		if( "undefined" != typeof CountUp ){
			var countup_n = 0;
			$('[data-role="countup"]').each(function(){
				countup_n ++;
				var 
				c_start    = $(this).data('start') || 0,
				c_end      = $(this).data('end') || $(this).text(),
				c_decimals = $(this).data('decimals') || 0,
				c_duration = $(this).data('duration') || 4;

				var c_options = {
					useEasing : false,
					useGrouping : true,
					separator : $(this).data('separator') || ',' ,
					decimal : $(this).data('decimal') || '.' ,
					prefix: $(this).data('prefix') || '',
					suffix: $(this).data('suffix') || ''
				} ;

				if(undefined==$(this).attr('id')){
					$(this).attr('id','id_countup_' + countup_n);
				}

				var cnt = new CountUp( $(this).attr('id') , c_start, c_end , c_decimals, c_duration, c_options );
				cnt.start();

			})
		}

		// rtl demo
		$('#rtl-button').on('click',function(){
			if($('body').attr('dir')=='rtl'){
				$('body').attr('dir','');
			}else{
				$('body').attr('dir','rtl');
			}
		})


})


