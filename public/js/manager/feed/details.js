var postDetails = function() {
	var getPost = function() {
		$(document).ready(function() {
           	$.ajax({
	            type: 'GET',
	            headers: [],
	            url: Site.wordpressUrl + '/posts/slug:' + Site.slug,
				beforeSend: function() {},
	            success: function (data) {
	                var post_html = '';
                    post_html += '<h2 class="blog-title">' + data.title + '</h2>';
                    post_html += '<div class="blog-desc">' + data.content + '</div>';
	                $('#news_details').html(post_html);
	            },
	            error: function (request, status, error) {
	                console.log(error);
	            }
	        });
        });
	}

	return {
        init: function() {
            getPost();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    postDetails.init();
});