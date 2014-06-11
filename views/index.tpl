{include file='header.tpl' index='1'}

  <body>
    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">{$SITE_NAME}</h3>
              {include file='menu.tpl' active='home'}
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">Step 1: Authenticate with Twitter.</h1>
            <p class="lead">Clicking the button below will authorize the app to post on Twitter on your behalf. Go ahead, give it a little click.</p>
            <p class="lead">
              <a href="{$SITE_ROOT}initialize/" class="btn btn-lg btn-default">Nothing bad will happen. Yet.</a>
            </p>
          </div>

{include file='footer.tpl'}