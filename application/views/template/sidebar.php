<div id="sidebar" style="background:#f2f2f2">

    <ul>
        <li id="search-2" class="widget widget_search"><h2 class="widgettitle">Pencarian</h2>
            <form role="search" method="post" id="searchform" action="<?php echo site_url('job/search') ?>" >
                <div>
                    <input type="text" name="q" id="q" />
                    <input type="submit" id="searchsubmit" value="Cari" />
                </div>
            </form></li>
        <li id="p2_recent_tags-3" class="widget widget_p2_recent_tags"><h2 class="widgettitle">Member</h2>
            <ul>
                <li><?php echo ($auth != false ? anchor('member', 'home') : '').($auth['user_type'] == 1 ? ' | '.anchor('admin', 'admin') : '') ?></li>
                <li><?php echo (is_array($auth) ? anchor('authenticate/logout', 'logout') : anchor('authenticate', 'login / register')) ?></li>
            </ul>

        </li>
    </ul>

    <div class="clear"></div>

</div> <!-- // sidebar -->