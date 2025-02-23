<?php

class Task
{
    protected $asana;

    public function __construct(Asana $asana)
    {
        $this->asana = $asana;
    }

    public function createReparatieTaskForCustomer(Customer $customer, Request $request)
    {
        $code_taak = $customer->generateCode($request->input('type_task'), false, true, Company::where('id', $request->input('company_id'))->first());
        $code = $customer->generateCode($request->input('type_task'), true, false, Company::where('id', $request->input('company_id'))->first());

        $asanaTaaknaam = $code .' ' . $request->input('field_2');
        $asanaAssignedTo = $request->input('assigned');
        $asanaFollowers = $request->input('Follower');
        $asanaKlantEmail = '';
        $asanaKlantTelefoon = '';

        $barcodeCode = explode(" ", $code_taak, 2)[0];
        $barcodeNaam = $customer->fullname;
        $barcodeTelefoon = $customer->primary_phone;
        $barcodeContact = $barcodeCode." ".$barcodeNaam." ".$barcodeTelefoon;
        $barcodeEmail = $customer->primary_email;
        $barcodeModel = $request->input('field_2');
        $barcodeKlacht = $request->input('field_3');

        // Standaard voor alle - hierboeven..

        $asanaNotities = $code_taak.PHP_EOL
            .'Merk/Model: '.trim($request->input('field_2')).PHP_EOL
            .'Klacht: '.trim($request->input('field_3')).PHP_EOL
            .'Afspraken: '.trim($request->input('field_4')).PHP_EOL
            .'Reparatie: ' .PHP_EOL
            .'Bedrag: '.PHP_EOL
        ;

        //$asanaTaskId = null; // Weg bij activeren volgende code
        // Create the task in Asana
        $asanaTaskId = $this->create(
            '701848333412968',
            $asanaTaaknaam,
            $asanaNotities,
            $asanaAssignedTo,
            $asanaFollowers,
            14,
            $asanaKlantEmail,
            $asanaKlantTelefoon
        );

        return [
            'pdflabel_link' => "/reparatie/pdflabel?contact=".urlencode($barcodeContact)."&email=".urlencode($barcodeEmail)."&barcode=".urlencode($barcodeCode)."&model=".urlencode($barcodeModel)."&klacht=".urlencode($barcodeKlacht)."",
            'asanaTaskId' => $asanaTaskId,
            'code_taak' => $code_taak,
            'users' => User::all(),
            'sticker' => [
                $code_taak,
                'Model/nummer: '.trim($request->input('field_2')),
                'Klacht: '.trim($request->input('field_3')),
                'Status:',
                'Bedrag:',
            ],
        ];
    }

    public function createBestellingTaskForCustomer(Customer $customer, Request $request)
    {
        $code_taak = $customer->generateCode($request->input('type_task'), false, true, Company::where('id', $request->input('company_id'))->first());
        $code = $customer->generateCode($request->input('type_task'), true, false, Company::where('id', $request->input('company_id'))->first());

        $asanaTaaknaam = $code .' ' . $request->input('field_2');
        $asanaAssignedTo = $request->input('assigned');
        $asanaFollowers = $request->input('Follower');
        $asanaKlantEmail = '';
        $asanaKlantTelefoon = '';

        $barcodeCode = explode(" ", $code_taak, 2)[0];
        $barcodeNaam = $customer->fullname;
        $barcodeTelefoon = $customer->primary_phone;
        $barcodeContact = $barcodeCode." ".$barcodeNaam." ".$barcodeTelefoon;
        $barcodeEmail = $customer->primary_email;
        $barcodeModel = $request->input('field_2');
        $barcodeKlacht = $request->input('field_3');

        // Standaard voor alle - hierboven

        $asanaNotities = $code_taak.PHP_EOL
            .'Merk/Model: '.trim($request->input('field_2')).PHP_EOL
            .'Omschrijving: '.trim($request->input('field_3')).PHP_EOL
            .'Afspraken: '.trim($request->input('field_4')).PHP_EOL
//            .'Reparatie: ' .PHP_EOL
            .'Bedrag: '.PHP_EOL
        ;

//        $asanaTaskId = null; // weg bij activeren van volgende code:
        // Create the task in Asana
        $asanaTaskId = $this->create(
            '722962993196059',
            $asanaTaaknaam,
            $asanaNotities,
            $asanaAssignedTo,
            $asanaFollowers,
            7,
            $asanaKlantEmail,
            $asanaKlantTelefoon
        );

        return [
            'asanaTaskId' => $asanaTaskId,
            'code_taak' => $code_taak,
        ];
    }

    public function createGeluidsverhuurTaskForCustomer(Customer $customer, Request $request)
    {
        $code_taak = $customer->generateCode($request->input('type_task'), false, true, Company::where('id', $request->input('company_id'))->first());
        $code = $customer->generateCode($request->input('type_task'), true, false, Company::where('id', $request->input('company_id'))->first());

        $asanaTaaknaam = $code .' ' . $request->input('field_2');
        $asanaAssignedTo = $request->input('assigned');
        $asanaFollowers = $request->input('Follower');
        $asanaKlantEmail = '';
        $asanaKlantTelefoon = '';

        $barcodeCode = explode(" ", $code_taak, 2)[0];
        $barcodeNaam = $customer->fullname;
        $barcodeTelefoon = $customer->primary_phone;
        $barcodeContact = $barcodeCode." ".$barcodeNaam." ".$barcodeTelefoon;
        $barcodeEmail = $customer->primary_email;
        $barcodeModel = $request->input('field_2');
        $barcodeKlacht = $request->input('field_3');

        // Standaard voor alle - hierboven

        $asanaNotities = $code_taak.PHP_EOL
            .'Klus: '.trim($request->input('field_2')).PHP_EOL
            .'Omschrijving: '.trim($request->input('field_3')).PHP_EOL
            .'Afspraken: '.trim($request->input('field_4')).PHP_EOL
//            .'Reparatie: ' .PHP_EOL
            .'Bedrag: '.PHP_EOL
        ;
//        $asanaTaskId = null; // Weg bij activeren volgende code
        // Create the task in Asana
       $asanaTaskId = $this->create(
            '826412713083910',
            $asanaTaaknaam,
            $asanaNotities,
            $asanaAssignedTo,
            $asanaFollowers,
            7,
            $asanaKlantEmail,
            $asanaKlantTelefoon
        );

        return [
            'asanaTaskId' => $asanaTaskId,
            'code_taak' => $code_taak,
        ];
    }

    public function createOfferteTaskForCustomer(Customer $customer, Request $request)
    {
        $code_taak = $customer->generateCode($request->input('type_task'), false, true, Company::where('id', $request->input('company_id'))->first());
        $code = $customer->generateCode($request->input('type_task'), true, false, Company::where('id', $request->input('company_id'))->first());

        $asanaTaaknaam = $code .' ' . $request->input('field_2');
        $asanaAssignedTo = $request->input('assigned');
        $asanaFollowers = $request->input('Follower');
        $asanaKlantEmail = '';
        $asanaKlantTelefoon = '';

        $barcodeCode = explode(" ", $code_taak, 2)[0];
        $barcodeNaam = $customer->fullname;
        $barcodeTelefoon = $customer->primary_phone;
        $barcodeContact = $barcodeCode." ".$barcodeNaam." ".$barcodeTelefoon;
        $barcodeEmail = $customer->primary_email;
        $barcodeModel = $request->input('field_2');
        $barcodeKlacht = $request->input('field_3');

        // Standaard voor alle - hierboven

        $asanaNotities = $code_taak.PHP_EOL
            .'Wensen: '.trim($request->input('field_2')).PHP_EOL
            .'Omschrijving: '.trim($request->input('field_3')).PHP_EOL
            .'Afspraken: '.trim($request->input('field_4')).PHP_EOL
//            .'Reparatie: ' .PHP_EOL
            .'Bedrag: '.PHP_EOL
        ;

//        $asanaTaskId = null; // Weg bij activeren volgende code
        // Create the task in Asana
       $asanaTaskId = $this->create(
            '1121646592245864',
            $asanaTaaknaam,
            $asanaNotities,
            $asanaAssignedTo,
            $asanaFollowers,
            3,
            $asanaKlantEmail,
            $asanaKlantTelefoon
        );

        return [
            'asanaTaskId' => $asanaTaskId,
            'code_taak' => $code_taak,
        ];
    }

    public function createTerugbelverzoekTaskForCustomer(Customer $customer, Request $request)
    {
        $code_taak = $customer->generateCode($request->input('type_task'), false, true, Company::where('id', $request->input('company_id'))->first());
        $code = $customer->generateCode($request->input('type_task'), true, false, Company::where('id', $request->input('company_id'))->first());

        $asanaTaaknaam = $code .' ' . $request->input('field_2');
        $asanaAssignedTo = $request->input('assigned');
        $asanaFollowers = $request->input('Follower');
        $asanaKlantEmail = '';
        $asanaKlantTelefoon = '';

        $barcodeCode = explode(" ", $code_taak, 2)[0];
        $barcodeNaam = $customer->fullname;
        $barcodeTelefoon = $customer->primary_phone;
        $barcodeContact = $barcodeCode." ".$barcodeNaam." ".$barcodeTelefoon;
        $barcodeEmail = $customer->primary_email;
        $barcodeModel = $request->input('field_2');
        $barcodeKlacht = $request->input('field_3');

        // Standaard voor alle - hierboven
        $asanaNotities = $code_taak.PHP_EOL
            .'Onderwerp: '.trim($request->input('field_2')).PHP_EOL
            .'Omschrijving: '.trim($request->input('field_3')).PHP_EOL
            .'Afspraken: '.trim($request->input('field_4')).PHP_EOL
//            .'Reparatie: ' .PHP_EOL
//            .'Bedrag: '.PHP_EOL
        ;

        //        $asanaTaskId = null; // Weg bij activeren volgende code
        // Create the task in Asana
        $asanaTaskId = $this->create(
            '1140557846447361',
            $asanaTaaknaam,
            $asanaNotities,
            $asanaAssignedTo,
            $asanaFollowers,
            1,
            $asanaKlantEmail,
            $asanaKlantTelefoon
        );

        return [
            'asanaTaskId' => $asanaTaskId,
            'code_taak' => $code_taak,
        ];
    }

    public function create($AsanaProjectnumber, $AsanaTaskName, $AsanaNotes, $AsanaAssignedTo, $AsanaFollowers, $AsanaNumOfDays, $AsanaEmail, $AsanaPhone) {
        $AsanaWorkspaceId = config('services.asana.workspace_id'); // The workspace where we want to create our task
        $AsanaStartDate = date('Y-m-d', (strtotime("+0 day")));
        $AsanaEndDate = date('Y-m-d', (strtotime("+" . $AsanaNumOfDays . " day")));

        if (empty($AsanaFollowers)) {
            $AsanaFollowers = [];
        }

        // Customfields not supported
        $AsanaCustomFields = [
            'gid' => config('services.asana.customfield_email'), // Custom field ID
            'name' => 'new_email', // Custom Field Name
            'type' => 'text', // Custom Field Type
            'text_value' => $AsanaEmail
        ];

        // First we create the task
        $result = $this->asana->createTask(array(
            'workspace' => $AsanaWorkspaceId, // Workspace ID
            'name'      => $AsanaTaskName, // Name of task
            'assignee'  => $AsanaAssignedTo, // Assign task to...
            'notes' => $AsanaNotes,
            'start_on' => $AsanaStartDate,
            'due_on'=> $AsanaEndDate,
            'followers' => $AsanaFollowers,
            'projects' => [$AsanaProjectnumber],
            //'custom_fields' => $AsanaCustomFields
        ));

        // As Asana API documentation says, when a task is created, 201 response code is sent back so...
        if ($this->asana->hasError()) {
            throw new AsanaException('Error while trying to connect to Asana, response code: ' . $this->asana->responseCode);
        }

        return $this->asana->getData()->gid; // Here we have the id of the task that have been created
    }

    public function get($taskId)
    {
        $this->asana->getTask($taskId);

        if ($this->asana->hasError()) {
            throw new AsanaException('Error while retrieving task from Asana, response code: ' . $this->asana->responseCode);
        }

        return $this->asana->getData();
    }
}