<style type="text/css">
    #usr_log modal-dialog
    {
        background-color: rgba(255,255,255,0.5);
    }
    
</style>

<script src="../Js/UserLogin_Reqs.js"></script>

<div id="usr_log" class="modal fade" role="dialog" style="z-index:9999;">
    <form class="form-horizontal">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: rgba(56, 248, 255, 0.6);">
                <div class="modal-header" style="border-bottom:none;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"align="center" style="color:white;">Log In to Client System</h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input id="user_id" type="text" class="form-control" name="user_id" placeholder="User ID"> 
                    </div>
                    <br />
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input id="pass" type="password" class="form-control" name="pass" placeholder="Password">
                    </div>
                    
                    <div class="form-group">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div align="center" id="log_captcha_box"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" id="log_captcha_code" class="form-control" maxlength="8" oninput="this.value = this.value.toUpperCase();" style="width: 66%; margin: auto; text-align: center;" placeholder="Please enter captcha!"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:none;">
                    <button type="button" class="btn btn-primary" onclick="List_SendRequest(cap2)">Log In</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger" >Exit</button>
                </div>
            </div>
        </div>
    </form>
</div>