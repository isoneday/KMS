<div class="container">
    <div class="row">
        <?php
        if ($success != '') {
            echo '    <div class="alert-custom text-center">';
            echo '      <div class="col-md-7 col-sm-10 col-xs-12 alert-banner">';
            echo '        <div class="alert alert-success alert-dismissible fade in" role="alert">';
            echo '          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            echo '          <strong>Warning!</strong> '.$success;
            echo '        </div>';
            echo '      </div>';
            echo '    </div>';
        }

        if ($fail != '') {
            echo '    <div class="alert-custom text-center">';
            echo '      <div class="col-md-7 col-sm-10 col-xs-12 alert-banner">';
            echo '        <div class="alert alert-warning alert-dismissible fade in" role="alert">';
            echo '          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            echo '          <strong>Warning!</strong> '.$fail;
            echo '        </div>';
            echo '      </div>';
            echo '    </div>';
        }
        ?>
        <div class="col-md-6">
            <div class="content-left">
                <div class="images-text">
                    <h1>It's Time to Give Discount to Your Lovely Customers!</h1>
                </div>
                <img src="<?php echo base_url() ?>images/register2.jpg"></img>
            </div>
        </div>
        <div class="col-md-6 form-make-center">
            <div class="content-right">
                <h1>Let's Join With Us !</h1>
                <form id="merchant_register" action="<?php echo $form_action ?>" method="post" accept-charset="utf-8">
                    <h4 style="margin-bottom:10px"> Data Pribadi</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" name="register_name" placeholder="Nama" minlength="2" required>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="merc_email" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="pass1" class="form-control" name="merc_pass" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="merc_pass2" placeholder="Confirm password" required>
                    </div>
                    <div class="form-group">
                        <input type="number" class="form-control" name="register_phone" placeholder="No. Telp" required>
                    </div>
                    <h4 style="margin-bottom:10px"> Data Perusahaan</h4>
                    <div class="form-group">
                        <input type="text" class="form-control" name="merc_name" placeholder="Nama Usaha" required>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="merc_business_field" placeholder="Bidang Usaha" required>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="merc_category_id">
                            <option value="0">-- Kategori Usaha --</option>          
                            <?php
                            if (!empty($merc_category)) {
                                for ($i = 0; $i < sizeof($merc_category); $i++) {
                                    echo'              <option value="' . $merc_category[$i]["merccategory_id"] . '">' . $merc_category[$i]["merccategory_name"] . '</option>';
                                }
                            }
                            ?>
                        </select>                
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="merc_phone" placeholder="No. Telp">
                    </div>
                    <button type="submit" class="btn btn-success pull-right">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<!-- This is custom script for this webpage -->
<script type="text/javascript">
    $("#merchant_register").validate({
        rules: {
            register_name: {
                required: true,
                minlength: 5
            },
            register_phone: {
                number: true,
                required: true,
                minlength: 5
            },
            merc_name: {
                required: true,
            },
            merc_pass2: {
                required: true,
                equalTo: "#pass1"
            },
            merc_email: {
                required: true,
                remote: {
                    url: "<?php echo base_url() . 'home/member_check/'; ?>",
                    type: "post",
                    data: {
                        login: function()
                        {
                            return $('#merchant_register :input[name="merc_email"]').val();
                        }
                    }
                }
            },
            merc_business_field: {
                required: true,
            },
            merc_phone: {
                number: true,
                required: true,
                minlength: 5
            },
            merc_category_id: {
                required: true
            }
        }
    });
</script>