<?php require 'include/header.php'; ?> <!---->

<!-- Begin page content -->

<div class="appContainer container_top container">
  <div class="row">
     <div class="col-md-12 col-xs-12 col-centered">
      <a href="welcome"><img class="img-responsive btn btn-link "src="../buttons/applestore_icon.png" alt="adgrego" height="120" width="240"/></a>
      <a href="welcome"><img class="img-responsive btn btn-link "src="../buttons/googleplay_icon.png" alt="adgrego" height="120" width="240"/></a>

      <!--<button type="button" class="appButton3 btn btn-default btn-lg">Windows Phone</button>-->
    </div>

    <div class=" mobileContainer col-md-12 col-xs-12 col-top">
      <img class="img-responsive center-block" src="../pictures/frame_frontpage.png" alt="Smiley face" height="525" width="265">

    </div>

   
  </div>
</div>
<link href='http://fonts.googleapis.com/css?family=Open+Sans|Maven+Pro:500' rel='stylesheet' type='text/css'>


<section class="main">
<a class="arrow-wrap" href="#content">
<span class="arrow"></span>
<!--<span class="hint">scroll</span>-->
</a>
  
  <div class="content" id="content">
    <h1>Content Section</h1>
    <p>
      The purpose of this arrow demo is to indicate that there is further content down the page. While studies have generally shown that users <em>do, in fact,</em> scroll (thus killing the worries about page fold), it still has become somewhat fashionable to indicate scroll intent.
    </p>
    <p>
      A subtle animation triggered after a period of time draws attention to the scroll indicator. Some jQuery hides the indicator after the user begins scrolling.
    </p>
    <h2>
      The CSS
    </h2>
    <pre>
.arrow-wrap {
  position:absolute;
  z-index:1;
  left:50%;
  top:-5em;
  margin-left:-5em;
  background:#111;
  width:10em;
  height:10em;
  padding:4em 2em;
  border-radius:50%;
  font-size:0.5em;
  display:block;
}

.arrow {
  float:left;
  position:relative;
  width: 0px;
  height: 0px;
  border-style: solid;
  border-width: 3em 3em 0 3em;
  border-color: #ffffff transparent transparent transparent;
  -webkit-transform:rotate(360deg)
}

.arrow:after {
  content:'';
  position:absolute;
  top:-3.2em;
  left:-3em;
  width: 0px;
  height: 0px;
  border-style: solid;
  border-width: 3em 3em 0 3em;
  border-color: #111 transparent transparent transparent;
  -webkit-transform:rotate(360deg)
}
    </pre>
    <h2>Animation</h2>
    <p>Be sure to use the correct vendor-prefixes</p>
    <pre>
  @-webkit-keyframes arrows {
    0% { top:0; }
    10% { top:12%; }
    20% { top:0; }
    30% { top:12%; }
    40% { top:-12%; }
    50% { top:12%; }
    60% { top:0; }
    70% { top:12%; }
    80% { top:-12%; }
    90% { top:12%; }
    100% { top:0; }
  }
  
  .arrow-wrap .arrow {
    -webkit-animation: arrows 2.8s 0.4s;
    -webkit-animation-delay: 3s;
  }
    </pre>
 
  </div>
  
</section>


<?php require 'include/footer.php'; ?>


