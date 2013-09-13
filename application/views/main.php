<div class="sleeve_main">
    <div id="main">
        <h2>serba satusewunan</h2>
        <ul id="postlist">
            <?php foreach ($jobs->result() as $row) : ?>
                <li id="prologue-2428" class="post-2428 post type-post status-publish format-status hentry category-uncategorized tag-yippe">
                    <h4>
                        <?php $user = explode("@", $row->user_email);
                        echo anchor('', $user[0]) ?>
                        <span class="meta">
                            <abbr title="2011-12-22T22:54:58Z"><?php echo $row->job_posted ?></abbr>			
                            <span class="actions">
    <?php echo (isset($user_id) ? anchor('job/join/' . $row->job_id, '[ ikut ]') : '') ?>
                            </span>
                            <span class="tags"><br /><?php echo anchor('job/member/' . $row->job_id, 'lihat yang join') ?></span>
                        </span>
                    </h4>

                    <div id="content-2428" class="postcontent">
                        <p><?php echo $row->job_detail ?></p><div class="sharedaddy"></div>
                    </div>
                    <div class="bottom-of-entry">&nbsp;</div>
                </li>
<?php endforeach; echo '<div style="float:right">halaman : '.$pagination.'</div>';?>
        </ul>
    </div> <!-- main -->
</div> <!-- sleeve -->