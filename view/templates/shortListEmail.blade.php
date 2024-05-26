@include('partials/header')

<section class="section dashboard" style="background-color: #f9f9f9; padding: 20px;">
    <table style="max-width: 600px; margin: 0 auto;">
        <tr>
            <td style="text-align: center;">
                <img src="https://www.upf.go.ug/wp-content/uploads/2018/06/header_banner.png?x89335" style="max-width: 150px; height: auto;" alt="logo">
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <h1 style="font-size: 24px; margin-top: 20px; margin-bottom: 10px;">Uganda Police Recruitment Portal</h1>
            </td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <div style="font-size: 18px; color: #333; margin-bottom: 20px;">
                    {{$body}}
                </div>
                <hr>
                <p style="font-size: 16px; color: #666; margin-bottom: 20px;">Thank you for using our portal. We are committed to providing you with the best recruitment experience.</p>
                <p style="font-size: 16px; color: #444; margin-bottom: 20px;">Our Mission: To enhance the quality of life for all people in Uganda through effective and efficient policing, while upholding the rule of law.</p>
                
            </td>
        </tr>
    </table>
</section>

@include('partials/footer')
