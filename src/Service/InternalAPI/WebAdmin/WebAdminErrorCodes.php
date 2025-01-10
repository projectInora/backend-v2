<?php

namespace App\Service\InternalAPI\WebAdmin;

trait WebAdminErrorCodes
{
    private string $CWE0000X = "Un-defined Exception!";
    private string $CWE0000Y = "Request data validation failed";
    private string $CWE00000 = "Invalid Request Data Format!";
    private string $BEI00001 = "Invalid image file!";
    private string $BEI00002 = "Invalid Request Data Format!";

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
    private string $CWE_ER034 = "Duplicate entity code!";
    private string $CWE_ER035 = "Duplicate entity branch code!";
    private string $CWE_ER036 = "Entity not found!";
    private string $CWE_ER037 = "Entity branch not found!";
    private string $CWE_ER038 = "Entity role not found!";
    private string $CWE_ER039 = "Username already exists!";
    private string $CWE_ER040 = "User already assigned to entity!";
    private string $CWE_ER041 = "User already assigned to entity branch!";
    private string $CWE_ER042 = "User entity branch record not found!";
    private string $CWE_ER043 = "Entity user not found!";

    private string $VME_ER001 = "User ticket qr not found!";
    private string $VME_ER002 = "Ticket destination mismatch!";
    private string $VME_ER003 = "User ticket date invalid!";
    private string $VME_ER004 = "Invalid ticket count!";
    private string $VME_ER005 = "Ticket state mismatch!";
    private string $VME_ER006 = "Ticket session mismatch!";
    private string $VME_ER007 = "Ticket session start time mismatch!";
    private string $VME_ER008 = "Ticket session end time mismatch!";
    private string $VME_ER010 = "User booking not found!";
    private string $VME_ER011 = "User destination invalid!";
    private string $VME_ER012 = "Tickets void failed!";

    public function getErrorMessage(string $errorCode): array
    {
        if(isset($this->{$errorCode})){
            return ['errorCode'=>$errorCode, 'message'=>$this->{$errorCode}];
        }

        return ['errorCode'=>'DME101', 'message'=>'Un-defined error code'];
    }
}