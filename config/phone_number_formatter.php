<?php

class PhoneNumberFormatter {
    private $countryCodes = [
        'Nederland' => '+31',
        // Voeg hier meer landcodes toe indien nodig
    ];

    /**
     * Alias voor formatPhoneNumber voor backwards compatibility
     */
    public function format($phoneNumber, $country = null) {
        return $this->formatPhoneNumber($phoneNumber, $country);
    }

    public function formatPhoneNumber($phoneNumber, $country = null) {
        // Verwijder alle niet-numerieke tekens
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        // Controleer of het telefoonnummer 10 cijfers bevat
        if (strlen($phoneNumber) == 10) {
            // Controleer of het een mobiel nummer is (begint met 06)
            if (substr($phoneNumber, 0, 2) == '06') {
                $formattedNumber = '6 ' . substr($phoneNumber, 2, 2) . ' ' . substr($phoneNumber, 4, 2) . ' ' . substr($phoneNumber, 6, 2) . ' ' . substr($phoneNumber, 8);
            } else {
                // Vast nummer
                $formattedNumber = substr($phoneNumber, 0, 3) . ' ' . substr($phoneNumber, 3, 2) . ' ' . substr($phoneNumber, 5, 2) . ' ' . substr($phoneNumber, 7);
            }

            // Voeg het landnummer toe als het land bekend is
            if ($country && isset($this->countryCodes[$country])) {
                return $this->countryCodes[$country] . ' ' . $formattedNumber;
            }

            return $formattedNumber;
        }

        // Als het telefoonnummer niet 10 cijfers bevat, retourneer het ongewijzigd
        return $phoneNumber;
    }
}
?>