{include file='header.tpl'}

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
            <h1 class="cover-heading">GAH! What are you doing?!</h1>
            <p class="lead">
              {$message}
            </p>
          </div>

{include file='footer.tpl'}