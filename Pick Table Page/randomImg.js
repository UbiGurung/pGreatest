var keyword = "random";

    $(document).ready(function(){

        $.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
        {
            tags: keyword,
            tagmode: "any",
            format: "json"
        },
        function(data) {
			for(var i = 0; i<25;i++)
			{
				var imgId = '#img_' + i;
				var rnd = Math.floor(Math.random() * data.items.length);

				var image_src = data.items[rnd]['media']['m'].replace("_m", "_b");
				$(imgId).attr('src', image_src);
			}
        });

    });