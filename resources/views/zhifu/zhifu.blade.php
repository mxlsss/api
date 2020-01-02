<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<form action="{{url('test/pay')}}" method="get">

    填写金额 ： <input type="text" onkeyup="this.value=this.value.replace(/\D/g,'')" name="amount" placeholder="只能输入数字">
    <input type="submit" value="提交">
</form>
</body>
</html>