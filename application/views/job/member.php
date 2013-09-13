<div class="sleeve_main">
    <div id="main">
        <h2>Member</h2>
        <?php echo '<p>'.$message.'</p>' ?>
        <p>
            <?php
            $ret = $members->row(0);
            if (isset($ret->id) && $ret->id == 0) {
                echo $ret->message;
            } else {
                echo "Pencari satusewu untuk <em>".$job_detail->job_detail."</em> :";
                
                $nData = $members->num_rows(); $i = 0; $col = 5;
                echo "<table border='0' cellspacing='5'>";
                foreach ($members->result() as $row) {
                    if($i % $col == 0 || $i == 0) echo "<tr>";
                    $user = explode('@', $row->user_email);
                    $status = job_status($row->status);
                    if($user_id == $job_detail->user_id ){
                        $r = explode('.', $user[1]);
                        echo "<td>".$user[0]." [at] ".$r[0]." [dot] ".$r[1]."<br>&rarr; ";
                        if($row->status == 0) echo anchor('member/status/'.$row->user_id.'/'.$row->job_id.'/1', 'approve');
                        else if($row->status == 1) echo anchor('member/status/'.$row->user_id.'/'.$row->job_id.'/2', 'selesai').' | '.anchor('job/status/'.$row->job_id.'/3', 'gagal');
                        else echo '<font color="' . $status['color'] . '">[' . $status['message'] . ']</font>&nbsp;&nbsp;';
                    }else{
                        echo "<td>".$user[0]." &rarr; ";
                        echo '<font color="' . $status['color'] . '">[' . $status['message'] . ']</font>&nbsp;&nbsp;';
                    }
                    echo "</td>";
                    if($i % $col == 0 && $i > 0) echo "</tr>";
                    $i++;
                }
                echo "</table>";
            }
            ?>
        </p>
    </div> <!-- main -->
</div> <!-- sleeve -->