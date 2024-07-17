var News = function() {
	var page = 1;
	var per_page = 10;

	var readNews = function() {
		$('#news-tab').click(function() {
			setTimeout(function(){ updateUnreadFeeds() }, 2000);
        });
	}

	var getPosts = function() {
		$.ajax({
            type: 'GET',
            headers: [],
            url: Site.wordpressUrl + '/posts?page=' + page +'&number=' + per_page,
            beforeSend: function() {},
            success: function (data, status, request) {
            	var total = data.found;
            	var pageCount = Math.ceil(total / per_page);
                var posts_html = '';
                if (total > 0) {
	                $.each(data.posts, function (index, post) {
	                    posts_html += '<div class="blog-area"><h2 class="blog-title"><a class="stretched-link" href="news/' + post.slug + '">' + post.title + '</a></h2><div class="blog-info"><span class="time"><i class="fas fa-calendar mr-1"></i>' + moment(post.date).format('DD/MM/YYYY HH:mm:ss') + '</span></div>';
	                    posts_html += '<div class="blog-desc">' + removeElements(post.excerpt, 'a.more-link') + '</div></div>';
	                });
	                posts_html += '<div class="row justify-content-between"><div class="col-6 col-md-3"><button type="button" class="btn btn-primary btn-block btn-sm btn-previous '+ (page == 1 ? 'disabled' : '') +'">Previous</button></div><div class="col-6 col-md-3"><button type="button" class="btn btn-primary btn-block btn-sm btn-next ' + (page == pageCount ? 'disabled' : '') +'">Next</button></div>'
                } else {
					posts_html = '<h2 class="text-center">No news yet</h2>'
                }
                $('#posts').html(posts_html);
            },
            error: function (request, status, error) {
                console.log(error);
            }
        });
	}

	var clickPrevious = function() {
		$(document).on('click', '.btn-previous', function() {
			page = page - 1;
			getPosts();
		});
	}

	var clickNext = function() {
		$(document).on('click', '.btn-next', function() {
			page = page + 1;
			getPosts();
		});
	}

	var removeElements = function(text, selector) {
	    var wrapped = $("<div>" + text + "</div>");
	    wrapped.find(selector).remove();
	    return wrapped.html();
	}

	var updateUnreadFeeds = function () {
        $.get({
            url: route('manage.feed.read', { division: Site.divisionID }),
            dataType:'json',
            success:function(response) {
                Global.getUnreadMessageCount(Site.divisionID);
            }
        }).fail(function(response) {
            console.log('Error while updating count');
        });
    }

	return {
        init: function() {
            readNews();
            clickNext();
            clickPrevious();
            getPosts();
        }
    };
}();

// Initialize when page loads
jQuery(function() {
    News.init();
});
