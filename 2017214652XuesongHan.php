<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>重庆邮电大学70周年校庆校友信息登记</title>
    
    <style type="text/css">
    
        body {
            background: #946AFE;
        }
        #container {
            width: 800px;
            height: auto;
            position: absolute;
            left: 50%;
            margin-left: -400px;
            text-align: center;
            background: #FE74A7;
            border-radius: 30px;
            box-shadow:0 0 16px #000;
        }
        .error {
            color: #DC143C;
            font-size: 10px;
            font-weight: bold;
        }
    
    </style>
    
</head>

<body>

	<?php
        
        //定义变量，初始为空
	    $nameErr = $genderErr = $phoneNumErr = $emailErr  = "";
	    $name = $gender = $phoneNum = $email = $comment = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (empty($_POST["name"])) {
                $nameErr = "姓名为必填项";
            }else {
                $name = test_input($_POST["name"]);
                
                //检测姓名是否合法，验证规则：只包含中文
                if (!preg_match("/^[\x{4e00}-\x{9fa5}]+$/u",$name)) {
                    $nameErr = "姓名只允许中文";
                }
            }
            
            if (empty($_POST["gender"])) {
                $genderErr = "性别为必填项";
            }else {
                $gender = test_input($_POST["gender"]);
            }
            
        
            if (empty($_POST["phoneNum"])) {
                $phoneNumErr = "手机号为必填项";
            }else {
                $phoneNum = test_input($_POST["phoneNum"]);
                
                //检测手机号码是否合法,验证规则：11位数字，以1开头
                if(!preg_match("/^1\d{10}$/",$phoneNum)) {
                    $phoneNumErr = "非法的手机号"; 
                }
            }
        
            if (empty($_POST["email"])) {
                $emailErr = "邮箱为必填项";
            }else {
                $email = test_input($_POST["email"]);
                
                //检测邮箱是否合法，验证规则：@前面的字符可以是英文字母和._- ，._-不能放在开头和结尾，且不能连续出现
                if (!preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i",$email)) {
                    $emailErr = "邮箱格式有误";
                }
            }
        
            if (empty($_POST["comment"])) {
                $comment = "";
            }else {
                $comment = test_input($_POST["comment"]);
            }
        }
        
        //当用户提交表单时：
        //使用trim()函数，去除用户输入数据中不必要的字符 (如：空格，tab，换行)
        //使用stripslashes()函数，去除用户输入数据中的反斜杠 (\)
        //将过滤函数写在test_input()中，提高代码的复用性
        function test_input($data) {
           
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            
            return $data;
        }
    ?>
    
    <div id = "container">
    
       	<h3>重庆邮电大学70周年校庆-校友信息登记：</h3>
    	
        <!--对用户所有提交的数据都通过htmlspecialchars()函数处理，以避免$_SERVER["PHP_SELF"]被利用-->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
       		
       		<p>姓名：</p>
       		<input type="text" name="name" value="<?php echo $name;?>">
       		<span class="error">* <?php echo $nameErr;?></span>
       		
       		<p>性别：</p>
       		<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?>  value="male">男
       		<input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?>  value="female">女
       		<span class="error">* <?php echo $genderErr;?></span>
       		
       		<p>手机号码：</p>
       		<input type="text" name="phoneNum" value="<?php echo $phoneNum;?>">
       		<span class="error">*<?php echo $phoneNumErr;?></span>
       		
       		<p>邮箱：</p>
       		<input type="text" name="email" value="<?php echo $email;?>">
       		<span class="error">* <?php echo $emailErr;?></span>
       		
       		<p>行业：</p>
       		<input type="checkbox" name="job[]" value="computer">计算机<br> 
        	<input type="checkbox" name="job[]" value="English">外国语<br> 
        	<input type="checkbox" name="job[]" value="automation">自动化<br>
       		
       		<p>备注：</p>
       		<textarea name="comment" rows="5" cols="20"><?php echo $comment;?></textarea>
    
    		<p>点击提交：</p>
       		<input type="submit" name="submit" value="提交">
       		
    	</form>
    
    </div>
	
	<?php
	
        echo "<h3>校友信息：</h3>";
        
        echo $name;
        echo "<br>";
        echo $gender;
        echo "<br>";
        echo $phoneNum;
        echo "<br>";
        echo $email;
        echo "<br>";
        
        $job = isset($_POST['job'])? $_POST['job'] : '';
        if(is_array($job)) {
            
            $sites = array(
                'computer' => '计算机',
                'English' => '外国语',
                'automation' => '自动化',
            );
            
            foreach($job as $val) {
                // PHP_EOL 为常量，用于换行
                echo $sites[$val] . "<br>";
            }
        }
        
        echo $comment;
        
    ?>

</body>
</html>