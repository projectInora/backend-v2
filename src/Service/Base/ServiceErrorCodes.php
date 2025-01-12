<?php

namespace App\Service\Base;

trait ServiceErrorCodes
{
    private string $CWE0000X = "Un-defined Exception!";
    private string $CWE0000Y = "Request data validation failed";
    private string $CWE00000 = "Invalid Request Data Format!";
    private string $BEI00001 = "Invalid image file!";
    private string $BEI00002 = "Invalid Request Data Format!";
    private string $BEI00003 = "Existing a record found!";

    private string $CWE_ER001 = "Entity type not found!";
    private string $CWE_ER002 = "Entity not found!";
    private string $CWE_ER003 = "Entity branch not found!";
    private string $CWE_ER004 = "Destination not found!";
    private string $CWE_ER005 = "Ticket type not found!";
    private string $CWE_ER006 = "Ticket group not found!";
    private string $CWE_ER007 = "Ticket origin not found!";
    private string $CWE_ER008 = "Currency not found!";
    private string $CWE_ER009 = "Tour category not found!";
    private string $CWE_ER010 = "Tour ager not found!";
    private string $CWE_ER011 = "Destination ticket not found!";
    private string $CWE_ER012 = "All booked";
    private string $CWE_ER013 = "Registration not started";
    private string $CWE_ER014 = "Registration period is over";
    private string $CWE_ER015 = "Ticket price not found!";
    private string $CWE_ER016 = "Ticket session not found!";
    private string $CWE_ER017 = "Ticket validity exception";
    private string $CWE_ER018 = "Invalid ticket count";
    private string $CWE_ER019 = "Review node not found!";
    private string $CWE_ER020 = "Banner group not found!";
    private string $CWE_ER021 = "Promo type not found!";
    private string $CWE_ER022 = "Page not found!";
    private string $CWE_ER023 = "Ticket booking not found!";
    private string $CWE_ER024 = "Finish order payment";
    private string $CWE_ER025 = "Payment not finished";
    private string $CWE_ER026 = "QR codes already released!";
    private string $CWE_ER027 = "QR release format not found!";
    private string $CWE_ER028 = "Ticket date not valid!";
    private string $CWE_ER029 = "Ticket off-session date!";
    private string $CWE_ER030 = "Ticket off-session selected!";
    private string $CWE_ER031 = "Ticket pricing date invalid with ticket date!";
    private string $CWE_ER032 = "Ticket pricing date invalid with ticket date!";
    private string $CWE_ER033 = "User ticket booking not found!";


    private string $WAE_FC001 = "Kingdom not found!";
    private string $WAE_FC002 = "Existing phylum found!";
    private string $WAE_FC003 = "Phylum not found!";
    private string $WAE_FC004 = "Existing phylum class found!";
    private string $WAE_FC005 = "Phylum class not found!";
    private string $WAE_FC006 = "Existing class order found!";
    private string $WAE_FC007 = "Class order not found!";
    private string $WAE_FC008 = "Existing family found!";
    private string $WAE_FC009 = "Family not found!";
    private string $WAE_FC010 = "Existing genus found!";
    private string $WAE_FC011 = "Genus not found!";
    private string $WAE_FC012 = "Existing species found!";
    private string $WAE_FC013 = "Existing climate zone found!";
    private string $WAE_FC014 = "Existing milieu found!";
    private string $WAE_FC015 = "Existing depth range found!";
    private string $WAE_FC016 = "Existing distribution range found!";
    private string $WAE_FC017 = "Existing fish dataset found!";
    private string $WAE_FC018 = "Classification species not found!";

    public function getErrorMessage(string $errorCode): array
    {
        if(isset($this->{$errorCode})){
            return ['errorCode'=>$errorCode, 'message'=>$this->{$errorCode}];
        }

        return ['errorCode'=>'DME101', 'message'=>'Un-defined error code'];
    }
}