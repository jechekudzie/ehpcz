<!DOCTYPE html>
<html>
<head>
    <title>Practicing Certificate</title>
    <style>
        @page {
            margin: 5px;
        }

        body {
            margin: 5px;
            padding-left: 15px;
            padding-right: 15px;
            background: url('certificate_background.jpg') no-repeat center center; /* Replace 'certificate-background.jpg' with your actual background image file */
            background-size: cover;
            font-family: 'Times New Roman', serif; /* Formal font type */
        }

        .certificate-container {
            width: 100%;
            padding: 20px;
            border: 5px solid #dddddd; /* Subtle solid border */
            box-shadow: 0 0 15px rgba(0,0,0,0.1); /* Soft shadow for depth */
            background-color: rgba(255, 255, 255, 0.8); /* Slightly transparent white overlay to enhance text readability */
        }

        h1, h3, h5, h6 {
            color: #333; /* Dark gray color for text */
        }

        a {
            color: #007bff; /* Classic link color */
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

</head>
<body style="background-color: lightblue;">
<div style="width: 100%;  padding-left: 10px;padding-right: 10px;">
    <div style="/*background-image:url('logo.png');*/background-size: contain;background-position: center;
        background-repeat: no-repeat;/* border: 2px dashed lightblue;*/ padding: 0 2% 6.12442rem">
        <br/>
        <br/>
        <br/>
        <h6 style="text-align: left;font-size: 15px;"><span style="color: red;font-size: 15px;">Certificate No:</span>{{substr($renewal->period,-2)}}
            /{{str_pad($renewal->id, 4, '0', STR_PAD_LEFT)}}</h6>
        <div style="text-align: center;">
            <img style="margin-top: -40px" height="120px" src="ehpcz_logo.png">
        </div>
        <div style="width: 80%; margin: auto; padding: 10px;">
            <h5 style="text-align: center; font-size: 15pt; color: black; font-weight: bolder;">
                ENVIRONMENTAL HEALTH PRACTITIONERS COUNCIL OF ZIMBABWE
            </h5>
        </div>

        <p style="text-align: center;font-size: 15px; margin-top: -15px;">14 Buckingham Rd, Harare, Zimbabwe.
            Phone +263 4 782260</p>
        <p style="text-align: center;font-size: 15px; margin-top: -10px;">Email: <a
                    href="mailto: admin@ehpcz.co.zw">admin@ehpcz.co.zw</a>, Website: <a
                    href="www.ehpcz.co.zw">www.ehpcz.co.zw</a></p>
        <h3 style="text-align: center;">Health Professions Act</h3>
        <h3 style="text-align: center;margin-top: -14px;">(Chapter 27:19)</h3>
        <h1 style="text-align: center;margin-top: 30px;">PRACTISING CERTIFICATE</h1>
        <table style="table-layout: fixed; width: 100%; ">
            <tr>
                <td style="padding: 15px">This is to certify that</td>
                <td style="padding: 15px">{{$practitioner->first_name.' '.$practitioner->last_name}}</td>
            </tr>
            <tr>
                <td style="padding: 15px">Registration Number</td>
                <td style="padding: 15px">{{$practitionerProfession->registration_number}}</td>
            </tr>
            <tr>
                <td style="padding: 15px">Is Authorised to practice as a/an</td>
                <td style="padding: 15px">{{$profession->name}}</td>
            </tr>
            <tr>
                <td style="text-align: center;padding: 20px;" colspan="2">Condition/s<br/>
                    {{$register->name}}
                </td>
            </tr>
        </table>
        <p style="text-align: center;">This certificate expires on</p>
        <p style="text-align: center; text-decoration: underline;margin-bottom: 40px;">{{  date('d F Y',strtotime($renewal->end_date)) }}</p>
        <div style="display: flex;padding: 20px;">
            <p style="margin-top: 35px;display: none">Date: {{date('d F Y',strtotime($renewal->updated_at))}}</p>
            <p style="position: absolute; right: 78px;">{!! $html !!}</p>
        </div>
    </div>
</div>
</body>
</html>
