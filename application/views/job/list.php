<div class="sleeve_main">
    <div id="main">
        <h2><?php echo $header ?></h2>
        <?php echo '<p>'.$message.'</p>' ?>
        <ul id="postlist">
            <?php $ret = $jobs->row(0); if(isset($ret->id) && $ret->id == 0) : echo $ret->message; else :?>
            <?php foreach($jobs->result() as $row) : ?>
            <li id="prologue-2428" class="post-2428 post type-post status-publish format-status hentry category-uncategorized tag-yippe">
                <h4>
                    <?php
                        $user = explode("@", $row->user_email);
                        echo anchor('',$user[0]);
                        if(isset($user_id) && $user_id != null){
                            $r = explode('.', $user[1]);
                            echo ' [at] '.$r[0].' [dot] '.$r[1];
                        }
                    ?>
                    <span class="meta">
                        <?php echo mdate("pada tanggal %d/%m/%Y jam %H:%i", human_to_unix($row->job_posted)); ?>
                        <span class="actions">
                            <?php
                                if(isset($user_id) && $user_id != null){
                                    if($user_id == $row->user_id){
                                        echo ' '.anchor('member/delete/'.$row->job_id, 'hapus &raquo;');
                                        if($row->job_status == 0){
                                            echo ' <strong>belum disetujui admin</strong>';
                                        }elseif($row->job_status == 1){
                                            echo ' '.anchor('member/job/'.$row->job_id.'/2', 'tutup &raquo;');
                                        }else{
                                            echo ' '.anchor('member/job/'.$row->job_id.'/1', 'buka &raquo;');
                                        }
                                    }else{
                                        echo anchor('member/join/'.$row->job_id, 'ikut &raquo;');
                                    }
                                }

                                if(isset($user_type) && $user_type == 1){
                                    if($row->job_status == 0)
                                        echo ' '.anchor('admin/status/'.$row->job_id.'/1', 'tampilkan &raquo;');
                                    else
                                        echo ' '.anchor('admin/status/'.$row->job_id.'/0', 'sembunyikan &raquo;');
                                }
                                
                                if(isset($mode) && $mode == 'join'){
                                    $status = job_status($row->status);
                                    echo ' <font color="' . $status['color'] . '">[' . $status['message'] . ']</font>';
                                }
                            ?>
                        </span>
                        <span class="tags"><br />kategori : <?php echo anchor('job/category/'.$row->category_id, $row->category_name).' - '.anchor('job/member/'.$row->job_id, 'member &rarr;') ?></span>
                    </span>
                </h4>

                <div id="content-2428" class="postcontent">
                    <p>&rarr; <?php echo $row->job_detail ?></p><div class="sharedaddy"></div>
                </div>
                <div class="bottom-of-entry">&nbsp;</div>
            </li>
            <?php endforeach; echo ($pagination ? '<div style="float:right">'.$pagination.'</div>' : '');  endif; ?>
        </ul>
        <?php echo anchor('member', '&larr; home') ?>
    </div> <!-- main -->
</div> <!-- sleeve -->