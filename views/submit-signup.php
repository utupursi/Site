<?php

$db = new Database();

$request=new Request();
$body = $request->getBody();
?>
<?php
if($db->signupUser($body['name'],$body['email'], $body['password'])):?>
       <?php redirect('/');?>
<?php else:?>
    <div style="color:red;font-size:20px;"> <?php echo array_shift($db->errors1);?></div>
    <div style="color:red;font-size:20px;"> <?php echo array_shift($db->passwordErr);?></div>
    <?php endif; ?>
<div>
    <h1>Sign up</h1>
    <form method="POST" action="/submit-signup">
    <div class="form-group">
 
 <label for="exampleInputEmail1">Name</label>
 <input type="name" class="form-control" id="exampleInputEmail1" name="name"
        placeholder="Enter name">
</div>
        <div class="form-group">
 
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" name="email"
                   placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
        </div>
        <button type="submit" name='submit' class="btn btn-primary">Submit</button>
    </form>
</div>
