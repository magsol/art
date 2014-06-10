{if $randomVar == 0}
  {include file='header.tpl'}
{else}
  {include file='header.tpl' index='1'}
{/if}

  <body>
    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">
          {$action}
          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Twathletic</h3>
              {include file='menu.tpl' active='home'}
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">404</h1>
            <p class="lead">
              <a href="http://difficultrun.nathanielgivens.com/wp-content/uploads/2013/03/2013-03-29-failboat-41.jpg" data-lightbox="image-5">All aboard the failboat!</a>
            </p>
          </div>

{include file='footer.tpl'}