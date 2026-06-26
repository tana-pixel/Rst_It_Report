<div class="header-search-form closed">
    <div class="search-form-wrapper">
        <div class="container">
        <!--Search form Start-->
            <form class="search_global" role="search" method="get" id="searchform-global" action="<?php echo esc_url(site_url())?>" >
                <fieldset>
                <div class="row search-form-row">
                 <input type="text" class="searchinput col-5" value="<?php echo esc_attr(get_search_query()); ?>" name="s" id="search-form-global" placeholder="<?php echo esc_attr__('Search keyword ...', 'autlines')?>" />
                    <div class="searchsubmit fl-secondary-bg">
                        <button type="submit" id="searchsubmit-global" class="fl-font-style-bolt-two default-btn submit-btn"><?php echo esc_attr__('Search', 'autlines')?></button>
                    </div>
                </div>
                </fieldset>
            </form>
        <!--Search form End-->
        </div>
    </div>
</div>