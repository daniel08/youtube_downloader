<?php require_once 'header.php';?>
<body>
<div id='container' class='large-10 columns large-centered'>
	<div id='header' class='large-8 columns large-centered'>
		<h2> Youtube Downloader </h2>
	</div>
<div id='main-wrapper' class='large-8 columns'>
	<ul class="tabs" data-tab>
  	<li class="tab-title active"><a href="#main-form" id="tab-main-form">Download</a></li>
  	<li class="tab-title"><a href="#search" id="tab-search-form">Search</a></li>
	</ul>
	<div id='main' class="tabs-content">
		<section id='main-form' role="tabpanel" class='content active'>
		
		<form action="" method="post" id="download-form">
		 <div class="row collapse">
        <div class="small-10 columns">
          <input type="text" placeholder="Youtube URL..." name="youtube-url" id="url-input" autofocus>
        </div>
        <div class="small-2 columns">
          <input type="submit" class="button postfix" name="Submit" id="submit" value="Go">
        </div>
      </div>
			<div class='row'>
				<fieldset><legend>Options</legend>
					<div class="switch round large">
						<h5 class="subheader">Audio Only</h5>
						<input id="audiocheck" type="checkbox" name="options['-x']" value='audio-only'/>
						<label for="audiocheck">Audio Only</label>
					</div>
					<fieldset><legend><h5 class="subheader">Naming</h5></legend>
						<div class='small switch radius left'>
							<input type="radio" name="filenaming" value="use-title" id="name-title" checked /><label for="name-title"></label>
						</div>
						<label>Video Title</label>
						<br class='clear'>
						<div class='small switch radius left'>
							<input type="radio" name="filenaming" value="use-clean-title" id="name-clean-title" /><label for="name-clean-title"></label>
						</div>
						<label>Video Title (Pretty)</label>
						<br class='clear'>
						<div class='small switch radius left'>
							<input type="radio" name="filenaming" value="use-id" id="name-id" /><label for="name-id"></label>
						</div>
						<label>Video ID</label>
						<br class='clear'>
						<div class="row collapse">
						<div class="large-6 columns">
          		<input type="text" name="filename" value="" />
		        </div>
		        <div class="large-1 columns left">
		          <span class="postfix" id="file-extension">.mp4</span>
						</div>
						</div>
					</fieldset>
						
				</fieldset>
			</div>
		</form>
		</section>
	<section id="search" role="tabpanel" class="content">
		<form action="" method="post" id="search-form">
			<div class="row collapse">
        <div class="small-10 columns">
          <input type="text" placeholder="Search Youtube" name="search-field" id="search-input">
        </div>
        <div class="small-2 columns">
          <input type="submit" class="button postfix" name="Search" id="search-but" value="Search">
        </div>
      </div>
		</form>
		<panel id="results">
			<ul id="result-list">
			</ul>
		<panel>
	</section>
	</div>
</div>
	<div id='sidebar' class='large-3 columns left'>
		<strong>Download Links:</strong>
		<ul id='download-list'>
		</ul>
	</div>
	<div class='row'>
		<div id='video-box' class='large-8 column'>
		
		</div>
	</div>
	
<div id='video-modal' class='reveal-modal' data-reveal role='dialog'>
	<div class='flex-video widescreen youtube' id='modal-video'>
		<iframe width="400" height="300" src="" frameborder="0" allowfullscreen></iframe>
	</div>
</div>

</div>


<?php require_once 'footer.php'; ?>
