{include file='header.tpl'}

  <body>
    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">Twathletic</h3>
              {include file='menu.tpl' active='home'}
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading">Step 2: Provide Garmin Connect info.</h1>
            <p class="lead">If you are <a href="{$user_url}" data-lightbox="image-3" data-title="{$user_handle}"><strong>{$user_name}</strong></a>, sah-WHEAT! If not, <a href="/twathletic/clear/"><strong>click this helpful link</strong></a>.</p>
            <p>
            <form class="form-horizontal" role="form" method="post" action="/twathletic/submit/">
              <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Username</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="username" id="inputEmail3" placeholder="Username">
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword3" class="col-sm-3 control-label">Password</label>
                <div class="col-sm-9">
                  <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password">
                </div>
              </div>
              <div class="form-group">
                <label for="inputTime3" class="col-sm-3 control-label">Stats will post at this time on the 1st (EST, lulz)</label>
                <div class="col-sm-9">
                    <select class="form-control" name="hour" style="width: 40%;">
                    {for $hour=8 to 20}
                        <option value="{$hour}"{if $hour == 12} selected="selected"{/if}>{$hour}</option>
                    {/for}
                    </select> 
                    <select class="form-control" name="minute" style="width: 40%;">
                    {for $min=0 to 59}
                        <option value="{$min}">{$min|string_format:"%02d"}</option>
                    {/for}
                    </select>
                </div>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default">Submit credentials</button>
                </div>
              </div>
            </form>
            </p>
          </div>

{include file='footer.tpl'}


