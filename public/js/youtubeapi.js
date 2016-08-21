var YoutubeApi = function(){
	this.key = 'AIzaSyDXNiW6aMvkxjeiKPQOp_2DBZE-uvwnQCY';
	this.infoUrl = 'https://www.googleapis.com/youtube/v3/videos';
	this.playlistUrl = 'https://www.googleapis.com/youtube/v3/playlists';
	this.searchUrl = 'https://www.googleapis.com/youtube/v3/search';
	this.watchUrl = 'https://www.youtube.com/watch?v=';
	this.videoUrl = '';
};


YoutubeApi.prototype.search = function(query){
	var numResults = 10;
	//ex: https://www.googleapis.com/youtube/v3/search?q=search_term&part=snippet&key=myapikey
	return $.ajax({
		url : this.searchUrl,
		data : {'q' : query, 'part': 'snippet,id',
						'type': 'video,playlist', 'maxResults': numResults, 'key': this.key},
		type : 'GET',
		dataType : 'json',
	});

};

YoutubeApi.prototype.getInfo = function(videoId){
	//ex: https://www.googleapis.com/youtube/v3/videos?id=9bZkp7q19f0&part=contentDetails&key={YOUR_API_KEY}
	return $.ajax({
		url : this.infoUrl,
		data : {'id' : videoId, 'part' : 'snippet', 'key' : this.key},
		type : 'GET',
		dataType : 'json'
	});
};

YoutubeApi.prototype.playlistVideos = function(playlistId){
	//ex: https://www.googleapis.com/youtube/v3/playlists?id=RDDVEeZ7jjHyA%23t%3D4&key={YOUR_API_KEY}
	return $.ajax({
		url: this.playlistUrl,
		data : {'id': playlistId,'part': 'snippet', 'key': this.key},
		type: GET,
		dataType: 'json'
	});
}



