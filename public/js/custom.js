var YoutubeApi = new YoutubeApi;
var videoId;
var videoTitle;
var requests = [];

$('document').ready(function(){
	$(':input').trigger('click change');

//Update Url in input field
$('#url-input').on('change input',function(e){
	var url = this.value;
	//first just check that the input is meaningful
	if( validUrl(url) ){
		//now check that its actually a Youtube video
		var vId = getVideoId(url);
		videoId = vId;
		YoutubeApi.getInfo(vId).then(function(info){
			if( typeof(info.items[0]) == 'object'  ){
			//TODO only do this if you get one video
				data = info.items[0].snippet;
				videoTitle = data.title;
				output = '<a href="#" data-reveal-id="video-modal" class="open-video-modal" for="'+ vId +'">'+
						'<img class="med-thumb" src="'+ data.thumbnails.default.url +'"></a>'+
					'<h4>'+videoTitle+'</h4>'+
					'<p>'+ data.description.substring(0,200) +'...</p>';
				$('#video-box').html(output);
				if( $('#name-title').attr('checked') ){
					$(':input[name=filename]').val(videoTitle);
				}
				else if( $('#name-id').attr('checked') ){
					$(':input[name=filename]').val(vId);
				}
				else if( $('#name-clean-title').attr('checked') ){
					$(':input[name=filename]').val(prettyName(vId));
				}
			}
			else{
				$('#video-box').html("");
				$(':input[name=filename]').val("");
			}
		});
	}
});

//Form Submission
$('#download-form').submit(function(e){
	parseForm($('#download-form'));
	YoutubeApi.videoUrl = $("#url-input").val();
	//**Add title to download list (disabled)
	if( getVideoId(YoutubeApi.videoUrl) ){
		var rid = getVideoId(YoutubeApi.videoUrl).concat("-" + Math.round(1000*Math.random()));
	}else return false; //TODO some error message
	//**Add loading animation
	$('#download-list').append(
			'<li id="'+rid+'">'+
				'<a href="" class="cancel-ajax" for="'+rid+'"></a>'+
				'<span>Working...</span>'+
				'<div class="progress round">'+
				'<span id="load-'+rid+'" class="meter"></span>'+
				'</div>'+
			'</li>');
	loading(document.getElementById("load-"+rid));
	var postdata = $('form#download-form').serialize();
	console.log(postdata); 
	console.log($('form#download-form'));
	postdata = postdata + '&functionCall=youtubeDl';
	var xhr =	$.ajax({
		url: 'middleman.php',
		type: 'POST',
		dataType: 'json',
		data: postdata,
		success: function(response){
			console.log(response);
			if( response.error ){
				$('#'+rid).html('Error: '+ response.errorUrl +'<br/><small>'+response.error+'</small>');
				//TODO return the attempted url with the error to display
				$('#'+rid).prop('title', response.error);
			}
			else{
				$('#'+rid).html('<a href="'+response.link+'" download="'+response.download+'">'+response.title +'</a>');
			}
		},
		error: function(e){
			$('#'+rid).html('Error: <small>'+postdata.filename+'</small>');
			$('#'+rid).prop('title', e.responseText);
			console.log(e);
		}
	});
	requests[rid] = xhr;
	console.log(requests);
	return false;
});

//Cancel Ajax request button
$("#download-list").on('click','.cancel-ajax', function(){
	var responseId = $(this).attr('for');
	console.log(requests);
	requests[responseId].abort();
	return false;
});

//Search Form Submission
$("#search-form").submit(function(e){
	//clear result list
	$("#result-list").empty();
	
	var q = $("#search-input").val();
	console.log(YoutubeApi);
	YoutubeApi.search(q).then(function(result){
		$.each(result.items, function(k, item){
		//console.log(item);
		//TODO check if playlist or video
			var info = item.snippet;
			var id = item.id.videoId;
			var elem = searchResult(id, info);
			$("#result-list").append(elem);
			
		});
	});

	return false;
});

//Click download icon on search result
$("#result-list").on('click', '.dl-link', function(e){
	var vId = this.id;
	console.log($(this));
	$('#tab-main-form').click();
	$('#url-input').val(YoutubeApi.watchUrl + vId).change();
	$('#url-input').trigger('input');
});

//filename options
$(':input[name=filenaming]').change(function(){
	if( $(this).attr('id') == 'name-title' ){
		if( typeof(videoTitle) != 'undefined' ){
			$(':input[name=filename]').val(videoTitle);
		}
	}
	else if( $(this).attr('id') == 'name-id' ){
		if( typeof(videoId) != 'undefined' ){
			$(':input[name=filename]').val(videoId);
		}
	}
	else if( $(this).attr('id') == 'name-clean-title' ){
		if( typeof(videoTitle) != 'undefined' ){
		//	var v1 = videoTitle.replace(/(\(Official[^\)]*\))/g,'');
		//	var v2 = v1.trim().replace(/[\-\/\. ]+/g, '_');
			$(':input[name=filename]').val(prettyName(videoTitle));
		}
	}
});

//Audio only options
$('#audiocheck').change(function(){
	if( this.checked ){
		$('#file-extension').html('.m4a');
	}else{
		$('#file-extension').html('.mp4');
	}
});

//Tabs
$('#tab-main-form').on('click', function(){
	$('#url-input').focus();
	$(':input').trigger('change click');
});
$('#tab-search-form').on('click', function(){
	$('#search-input').focus();
});

//Modal stuff
$('#container').on('click', '.open-video-modal', function(){
	var videoId = $(this).attr('for');
	$('#modal-video iframe').attr('src','https://www.youtube.com/embed/'+ videoId +'?autoplay=1');
});

}); //END of document.ready
/****************************************
*************Helper Functions***********/
function validUrl(urlTest){
	//it has to be a valid Youtube url
	var regex = /(https?:\/\/)?(www\.)?youtube\.com(\/watch)?\?v=[\w\d-]{6,}/;
	return regex.test(urlTest);
}

function getVideoId(url){
	var regex = /([^&=]+)=?([^&]*)/;
	var matches = url.match(regex);
	if( matches ){
		return matches[2];
	}
	else{ return false; }
}

function loading(e){
	var percent = 0;
	
	function animate(){
		percent += 2;
		e.style.width = percent+"%";
		if( percent == 100 ) percent = 0;
	}
	
	var id = setInterval(animate,50); 
}

function searchResult(id, snippet){
	var out = "<li class='search-result'>"+
				"<a href='"+YoutubeApi.watchUrl + id +"' target='_blank' class='youtube-link'>"+
					"<img class='img-link' src='img/youtube.png'>"+
				"</a>"+
				"<a>"+
					"<img id='"+id+"' class='dl-link img-link' src='img/download.png'>"+
				"</a>"+
				"<a href='#' data-reveal-id='video-modal' class='open-video-modal' for='"+ id +"'>"+
				"<img class='med-thumb left' src='"+snippet.thumbnails.default.url+"'></img>"+
				"</a>"+
				"<h4>"+snippet.title+"</h4>"+
				"<p>"+snippet.description+"</p>"+
				"<br class='clear'>"+
				"</li>";
	return out;
}

function parseForm(objForm){
	var formData = {};
	$.each(objForm.find('input'), function(k, input){
		formData[input.name] = input.value;
	});
}

function prettyName(name){
	var v1 = name.replace(/(\(Official[^\)]*\))/g,'');
	var v2 = v1.trim().replace(/[\-\/\. ]+/g, '_');
	return v2;
}




