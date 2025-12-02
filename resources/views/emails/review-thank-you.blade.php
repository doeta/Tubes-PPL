<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terima Kasih atas Review Anda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9fafb;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-radius: 0 0 5px 5px;
        }
        .product-info {
            background-color: white;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
        }
        .rating {
            color: #fbbf24;
            font-size: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6b7280;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Terima Kasih atas Review Anda!</h1>
    </div>
    
    <div class="content">
        <p>Halo {{ $review->guest_name }},</p>
        
        <p>Terima kasih telah memberikan review untuk produk di marketplace kami. Feedback Anda sangat berharga bagi kami dan membantu pembeli lain dalam membuat keputusan pembelian.</p>
        
        <div class="product-info">
            <h3>Detail Review Anda:</h3>
            <p><strong>Produk:</strong> {{ $product->name }}</p>
            <p><strong>Rating:</strong> <span class="rating">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</span> ({{ $review->rating }}/5)</p>
            @if($review->comment)
            <p><strong>Komentar:</strong></p>
            <p style="font-style: italic;">"{{ $review->comment }}"</p>
            @endif
        </div>
        
        <p>Review Anda telah berhasil dipublikasikan dan dapat dilihat oleh pengunjung lainnya di halaman produk.</p>
        
        <p>Kami berharap Anda puas dengan pengalaman berbelanja Anda dan kami tunggu kunjungan Anda kembali!</p>
        
        <p>Salam hangat,<br>
        <strong>Tim Marketplace</strong></p>
    </div>
    
    <div class="footer">
        <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
    </div>
</body>
</html>
