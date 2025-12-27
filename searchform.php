<?php
global $template_dir;
?>
<form role="search" method="get" id="search-form" class="search-form" action="<?= esc_url( home_url( '/' ) );?>">
    <div class="input-group">
        <input class="form-control" placeholder="24/7 NOODSERVICE" type="search" value="<?=get_search_query();?>" name="s" id="s" >
        <span class="input-group-btn">
            <button class="btn btn-white" type="button"></button>
        </span>
        <input type="hidden" name="post_type[]" value="product" />
        <input type="hidden" name="post_type[]" value="presets" />
    </div>
</form>