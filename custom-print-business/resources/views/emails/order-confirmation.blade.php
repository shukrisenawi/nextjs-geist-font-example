<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px;">
        <h1 style="color: #28a745; margin: 0;">Order Confirmation</h1>
    </div>
    
    <p>Dear {{ $order->customer_name }},</p>
    
    <p>Thank you for your order! We're excited to let you know that we've received your order and it's being processed.</p>
    
    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <h2 style="margin: 0 0 10px 0;">Order Details</h2>
        <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
        <p><strong>Order Date:</strong> {{ $order->created_at->format('d M Y') }}</p>
        <p><strong>Total Amount:</strong> RM {{ number_format($order->total_amount, 2) }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    </div>
    
    <h3 style="margin: 20px 0 10px 0;">Order Items</h3>
    <table style="width: 100%; border-collapse: collapse; margin: 10px 0;">
        <thead>
            <tr style="background-color: #f8f9fa;">
                <th style="padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Product</th>
                <th style="padding: 8px; text-align: center; border-bottom: 1px solid #ddd;">Quantity</th>
                <th style="padding: 8px; text-align: right; border-bottom: 1px solid #ddd;">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td style="padding: 8px; border-bottom: 1px solid #ddd;">{{ $item->product->name }}</td>
                    <td style="padding: 8px; text-align: center; border-bottom: 1px solid #ddd;">{{ $item->quantity }}</td>
                    <td style="padding: 8px; text-align: right; border-bottom: 1px solid #ddd;">RM {{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <h3 style="margin: 0 0 10px 0;">Shipping Information</h3>
        <p><strong>Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Email:</strong> {{ $order->customer_email }}</p>
        <p><strong>Phone:</strong> {{ $order->customer_phone }}</p>
        <p><strong>Address:</strong> {{ $order->customer_address }}</p>
    </div>
    
    <div style="background-color: #e8f5e8; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <h3 style="margin: 0 0 10px 0;">Next Steps</h3>
        <ul style="margin: 0; padding-left: 20px;">
            <li>Your order is being processed and will be shipped soon.</li>
            <li>You'll receive tracking information once your order is shipped.</li>
            <li>If you have any questions, please contact our customer support.</li>
        </ul>
    </div>
    
    <p style="margin-top: 20px;">If you have any questions about your order, please don't hesitate to contact us.</p>
    
    <p style="margin-top: 20px;">Thank you for choosing our service!</p>
    
    <p style="margin-top: 20px; color: #666;">
        Best regards,<br>
        The Custom Print Team
    </p>
</body>
</html>
