$( document ).ready(function() {
    $('.image-upload input[name="image"]').change( function() {
        readURL(this);
    });
});

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function (e) {
			let ulimg = $('.image-upload img');
			if(ulimg.length == 0) {
				ulimg = $('<img class="img-thumbnail">');
				$('.image-upload').append(ulimg);
			}
			ulimg
				.attr('src', e.target.result)
				.width(300)
				.height(200);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
