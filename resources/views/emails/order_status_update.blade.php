<!DOCTYPE html>
<html>
<head>
<title>Order Status Update</title>
    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
    </style>
</head>
<body>
    
<p>Dear <strong>{{ $firstName }} {{ $lastName }},</strong></p>
    <p>Your order for <strong>{{ $orderNo }}</strong> has been updated to the following status: <strong>{{ $status }}.</strong></p>
    <p><strong>Date: {{ $date }}</strong></p>
    
    <div style="border: 2px solid gray; border-radius: 10px; box-shadow: 3px 3px 5px grey; padding: 20px; width: fit-content; display: flex; flex-direction: column; justify-content: center; align-items: center;">

<p>
<strong style="text-decoration: underline; color: orange; font-size: 20px; font-weight: bold;">Ordered Products</strong><br/><br/>     
<strong>  {!! nl2br(e($formattedName)) !!}</strong>
</p>
</div>
    

    <p>We appreciate your business and look forward to serving you again.If you have any questions or concerns about your order, please don't hesitate to reach out to our customer support team. We're here to help!</p> 
    <p>Thank you for your purchase from Yeneta Language and Cultural Academy!</p>
   
    
    <h4><strong>Warm regards,</strong> <br>
<strong>School Administration</strong> <br>
<strong>Yeneta Language and Cultural Academy</strong></h4>
<img src="https://static.vecteezy.com/system/resources/previews/014/440/919/original/email-icon-design-in-blue-circle-png.png" alt="Email" style="height: 18px; width: 18px;">  admission@yenetaschool.com
<br/><img src="https://static.vecteezy.com/system/resources/previews/014/440/919/original/email-icon-design-in-blue-circle-png.png" alt="Email" style="height: 18px; width: 18px;">   Info@yenetaschool.com
<br>
<img src="https://toppng.com/uploads/preview/hone-icon-866-986-8942-book-online-phone-icon-png-blue-115633551488jsnijarwa.png" alt="Phone" style="height: 18px; width: 18px;">  +12403748205<br/>
<img src="https://toppng.com/uploads/preview/hone-icon-866-986-8942-book-online-phone-icon-png-blue-115633551488jsnijarwa.png" alt="Phone" style="height: 18px; width: 18px;">  +12403534436

</body>
</html>