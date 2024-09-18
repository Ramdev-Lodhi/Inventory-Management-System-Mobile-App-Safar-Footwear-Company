<?php //print_r($student_data); die();?>

<div id="page-wrapper">
    <div class="rows">
        <div class="form-three widget-shadow">
            <form class="form-horizontal" action="<?php echo base_url('Email/email_send')?>" method="POST">
        
                <div class="form-group">
                    <label for="selector1" class="col-sm-2 control-label">Sender<span style="color:red;">:</span></label>
                    <div class="col-sm-8">
                        <input disabled="" type="email" class="form-control" id="email1" placeholder="pranjal.pandit900@gmail.com"
                            name="semail" required />
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label for="selector1" class="col-sm-2 control-label">To<span style="color:red;">:</span></label>
                    <div class="col-sm-8"> -->
                        <?php foreach($student_data as $data){?>
                        <input type="hidden" class="form-control"  name="email[]" value="<?php echo $data;?>" /> 
                  <?php }?>  
                <!-- </div>
                </div> -->
                <div class="form-group">
                    <label for="selector1" class="col-sm-2 control-label">Subject<span style="color:red;">:</span></label>
                    <div class="col-sm-8">
                            <textarea  class="form-control" id="exampleFormControlTextarea1" rows="1" name="subject" placeholder="subject" required></textarea>
                            <textarea  class="form-control" id="exampleFormControlTextarea1" rows="15" name="textarea" placeholder="message....." required></textarea>
                    </div>
                </div>
                <div class="col-sm-offset-2">
                    <input type="submit" name="button" value="Send" class="btn btn-success" />
                </div>
            </form>
        </div><br>
    </div>
</div>