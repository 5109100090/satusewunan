<script>
    $(document).ready(function() {
        $("textarea#detail").keyup(function(){
            var l = $(this).val().length;
            $("p#detail-count").html(l + "/140");
            if(l > 140) $("#simpan").attr('disabled','disabled');
            else $("#simpan").removeAttr('disabled');
        }); 
    });
</script>
<div class="sleeve_main">
    <div id="main">
        <h2>sugeng rawuh</h2>
        <div style="float:right">
            <p>Pendapatan Rp <?php $p = $my_job_status_num*100000; echo number_format($p) ?>,-</p>
            <?php
                echo
                anchor('member/post', 'Job saya buat&nbsp;&nbsp;&nbsp;('.$post_num.') &rarr;') . '<br />' .
                anchor('member/join', 'Job saya ikuti&nbsp;&nbsp;&nbsp;('.$join_num.') &rarr;') . '<br />';
                //anchor('member/job', 'Job saya tutup&nbsp;&nbsp;('.$job_close_num.') &rarr;') . '<br />';
            ?>
        </div>
        <div style="width:400px">
            buat <em>satusewunan</em> baru
            <?php
            echo $message;
            echo form_open('member/post');
            $detail = array(
                'name' => 'detail',
                'id' => 'detail',
                'value' => set_value('detail'),
                'maxlength' => '140',
                'style' => 'width:100%;height:50px',
            );
            $options[''] = '&rarr; Kategori';
            foreach($category as $r)
                $options[$r->category_id] = $r->category_id.' - '.$r->category_name;
            
            echo form_dropdown('category', $options).'<br />'.form_textarea($detail) . '<br />' . '<p id="detail-count" style="float:right">0/140</p>' . form_submit(array('name' => 'simpan', 'value' => 'simpan', 'id' => 'simpan'));
            echo form_close();
            echo "<p>&nbsp;</p>";
            ?>
        </div>
    </div> <!-- main -->
</div> <!-- sleeve -->