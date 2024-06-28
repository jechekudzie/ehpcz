<?php

namespace App\Http\Controllers;

use App\Models\Renewal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    //SHOW
    public function show(Renewal $renewal)
    {
        $practitionerProfession = $renewal->practitionerProfession;
        $practitioner = $renewal->practitioner;

        $profession = $practitionerProfession->profession;

       //loop through $practitionerProfession professional qualifications and get latest
        $latestQualification = $practitionerProfession->professionalQualifications()->first();

        $register = $latestQualification->register;
        $name = $practitioner->first_name . $practitioner->last_name .'_'. $renewal->period.'.pdf';

        $qr_code = QrCode::size(150)->generate('http://ehpcz.co.zw/' . $practitioner->slug);
        $html = '<img src="data:image/svg+xml;base64,' . base64_encode($qr_code) . '"  width="100" height="100" />';
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML(view('practitioners.certificates.show')
            ->with('html', $html)
            ->with('practitioner', $practitioner)
            ->with('register', $register)
            ->with('profession', $profession)
            ->with('practitionerProfession', $practitionerProfession)
            ->with('renewal', $renewal))
            ->setPaper('a4', 'portrait');

        return $pdf->stream($name);


       /* return view('practitioners.certificates.show', compact('renewal', 'practitionerProfession',
            'practitioner', 'profession','latestQualification','register'));*/
    }

}
