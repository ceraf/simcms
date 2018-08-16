$(function() {
    $('.preview_field a').click(function(e){
		$(this).parent().find('input[type=file]').click();
	})
	
    $('.preview_field input').change(function(e){

                var file = this.files[0];
				var aImg = $('.preview_field img');
				var reader = new FileReader();
				reader.onload = (function(aImg) {
					return function(e) {
						aImg.attr('src', e.target.result);
					};
				})(aImg);
					
				reader.readAsDataURL(file);

	})
});