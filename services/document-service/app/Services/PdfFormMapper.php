<?php

namespace App\Services;

final class PdfFormMapper
{
    // Many PDF form checkboxes want "Yes" or "On" when checked, and "Off" when unchecked.
    // Change CHECKED_VALUE to "On" if your PDF uses that instead.
    private const CHECKED_VALUE = 'Yes';
    private const UNCHECKED_VALUE = 'Off';

    private static function safe($v): string
    {
        if ($v === null) return '';
        if (is_bool($v)) return $v ? '1' : '0';
        return (string)$v;
    }

    private static function checkbox(bool $checked): string
    {
        return $checked ? self::CHECKED_VALUE : self::UNCHECKED_VALUE;
    }

    /**
     * Split a single address string into 2 lines for fields like *_r1 and *_r2.
     * Adjust as needed (e.g., comma-based splitting).
     */
    private static function addressLines(?string $addr): array
    {
        $addr = trim((string)($addr ?? ''));
        if ($addr === '') return ['', ''];

        // Prefer explicit newlines if present
        if (str_contains($addr, "\n")) {
            $parts = preg_split("/\r\n|\n|\r/", $addr);
            $l1 = $parts[0] ?? '';
            $l2 = $parts[1] ?? '';
            return [trim($l1), trim($l2)];
        }

        // Otherwise keep all on first line
        return [$addr, ''];
    }

    /**
     * @param array $form The decoded JSON from the frontend (associative array).
     * @return array Flat PDF-field-name => value array.
     */
    public static function map(array $form): array
    {
        $pi    = $form['declarant']['personal_information'] ?? [];
        $govId = $pi['government_id'] ?? [];

        $spouse = $form['spouse'] ?? null; // may be null

        [$decAddr1, $decAddr2] = self::addressLines($pi['office_address'] ?? '');
        [$spAddr1, $spAddr2]   = self::addressLines($spouse['personal_information']['office_address'] ?? '');

        $filingType = (string)($form['form_metadata']['filing_type'] ?? '');

        // Adjust these comparisons to your real filing_type values
        $isAssumption = ($filingType === 'ASSUMPTION_OF_OFFICE');
        $isAnnual     = ($filingType === 'ANNUAL');
        $isExit       = ($filingType === 'EXIT');
        $isJoint      = ($filingType === 'JOINT');
        $isSeparate   = ($filingType === 'SEPARATE');

        $children = $form['children_below_18'] ?? [];
        $c1 = $children[0] ?? [];
        $c2 = $children[1] ?? [];
        $c3 = $children[2] ?? [];

        $realProps = $form['assets']['real_properties'] ?? [];
        $persProps = $form['assets']['personal_properties'] ?? [];
        $liabs     = $form['liabilities'] ?? [];

        $biz = $form['business_interests'] ?? ['has_business_interest' => false, 'entries' => []];
        $rel = $form['relatives_in_government'] ?? ['has_relatives' => false, 'entries' => []];

        $pdf = [
            // ---- Filing checkboxes ----
            'assumption_of_office_check_box' => self::checkbox($isAssumption),
            'annual_filing_check_box'        => self::checkbox($isAnnual),
            'exit_check_box'                 => self::checkbox($isExit),
            'joint_filing_check_box'         => self::checkbox($isJoint),
            'sep_filing_check_box'           => self::checkbox($isSeparate),

            'filing_not_applicable_check_box'     => self::checkbox($filingType === ''),
            'mult_spouse_not_applicable_check_box'=> self::checkbox($spouse === null),

            // If your PDF expects these text fields to be filled too, set them accordingly
            'assumption_of_office' => '',
            'annual_filing'        => '',
            'exit'                 => '',

            // ---- Declarant ----
            'declarant_family_name'      => self::safe($pi['last_name'] ?? ''),
            'declarant_first_name'       => self::safe($pi['first_name'] ?? ''),
            'declarant_mi'               => self::safe($pi['middle_initial'] ?? ''),
            'declarant_position'         => self::safe($pi['position'] ?? ''),
            'declarant_agency_office'    => self::safe($pi['agency_office'] ?? ''),
            'declarant_office_addr_r1'   => $decAddr1,
            'declarant_office_addr_r2'   => $decAddr2,

            // ---- Spouse ----
            'spouse_family_name'   => self::safe($spouse['last_name'] ?? ''),
            'spouse_first_name'    => self::safe($spouse['first_name'] ?? ''),
            'spouse_mi'            => self::safe($spouse['middle_initial'] ?? ''),
            'spouse_position'      => self::safe($spouse['position'] ?? ''),
            'spouse_agency_office' => self::safe($spouse['agency_office'] ?? ''),

            // Your PDF has both spouse_office_addr and mult_spouse_r1/r2.
            // Populate both safely.
            'spouse_office_addr' => self::safe($spouse['personal_information']['office_address'] ?? ''),
            'mult_spouse_r1'     => $spAddr1,
            'mult_spouse_r2'     => $spAddr2,

            // ---- Children (3 rows) ----
            'umarried_children_name_r1' => self::safe($c1['name'] ?? ''),
            'umarried_children_age_r1'  => self::safe($c1['age'] ?? ''),
            'umarried_children_name_r2' => self::safe($c2['name'] ?? ''),
            'umarried_children_age_r2'  => self::safe($c2['age'] ?? ''),
            'umarried_children_name_r3' => self::safe($c3['name'] ?? ''),
            'umarried_children_age_r3'  => self::safe($c3['age'] ?? ''),

            // ---- Govt IDs (PDF has 2 rows) ----
            'govt_id_c1'     => self::safe($govId['type'] ?? ''),
            'id_no_c1'       => self::safe($govId['id_number'] ?? ''),
            'date_issued_c1' => self::safe($govId['date_issued'] ?? ''),
            'govt_id_c2'     => '',
            'id_no_c2'       => '',
            'date_issued_c2' => '',

            // ---- Business / Relatives flags ----
            'business_check_box'  => self::checkbox((bool)($biz['has_business_interest'] ?? false)),
            'relatives_check_box' => self::checkbox((bool)($rel['has_relatives'] ?? false)),

            // ---- Certification ----
            'date' => self::safe($form['certification']['date_signed'] ?? ''),
        ];

        // ---- Real properties table: r1..r4, c1..c8 ----
        for ($i = 0; $i < 4; $i++) {
            $row = $realProps[$i] ?? [];
            $r = $i + 1;

            $pdf["real_properties_r{$r}c1"] = self::safe($row['description'] ?? '');
            $pdf["real_properties_r{$r}c2"] = self::safe($row['kind'] ?? '');
            $pdf["real_properties_r{$r}c3"] = self::safe($row['exact_location'] ?? '');
            $pdf["real_properties_r{$r}c4"] = self::safe($row['assessed_value'] ?? '');
            $pdf["real_properties_r{$r}c5"] = self::safe($row['fair_market_value'] ?? '');
            $acq = $row['acquisition'] ?? [];
            $pdf["real_properties_r{$r}c6"] = self::safe($acq['year'] ?? '');
            $pdf["real_properties_r{$r}c7"] = self::safe($acq['mode'] ?? '');
            $pdf["real_properties_r{$r}c8"] = self::safe($acq['cost'] ?? '');
        }

        // ---- Personal properties table: r1..r6, c1..c3 ----
        // Example assumes: description, year_acquired, acquisition_cost
        for ($i = 0; $i < 6; $i++) {
            $row = $persProps[$i] ?? [];
            $r = $i + 1;

            $pdf["personal_properties_r{$r}c1"] = self::safe($row['description'] ?? '');
            $pdf["personal_properties_r{$r}c2"] = self::safe($row['acquisition_year'] ?? '');
            $pdf["personal_properties_r{$r}c3"] = self::safe($row['acquisition_cost'] ?? '');
        }

        // ---- Liabilities table: r1..r4, c1..c3 ----
        // Example assumes: nature, name_of_creditor, outstanding_balance
        for ($i = 0; $i < 4; $i++) {
            $row = $liabs[$i] ?? [];
            $r = $i + 1;

            $pdf["liabilities_r{$r}c1"] = self::safe($row['nature'] ?? '');
            $pdf["liabilities_r{$r}c2"] = self::safe($row['name_of_creditor'] ?? '');
            $pdf["liabilities_r{$r}c3"] = self::safe($row['outstanding_balance'] ?? '');
        }

        // ---- Business interests table: r1..r3, c1..c4 ----
        $bizEntries = $biz['entries'] ?? [];
        for ($i = 0; $i < 3; $i++) {
            $row = $bizEntries[$i] ?? [];
            $r = $i + 1;

            $pdf["business_r{$r}c1"] = self::safe($row['business_name'] ?? '');
            $pdf["business_r{$r}c2"] = self::safe($row['business_address'] ?? '');
            $pdf["business_r{$r}c3"] = self::safe($row['nature_of_business'] ?? '');
            $pdf["business_r{$r}c4"] = self::safe($row['date_of_acquisition'] ?? '');
        }

        // ---- Relatives table: r1..r5, c1..c4 ----
        $relEntries = $rel['entries'] ?? [];
        for ($i = 0; $i < 5; $i++) {
            $row = $relEntries[$i] ?? [];
            $r = $i + 1;

            $pdf["relatives_r{$r}c1"] = self::safe($row['name'] ?? '');
            $pdf["relatives_r{$r}c2"] = self::safe($row['relationship'] ?? '');
            $pdf["relatives_r{$r}c3"] = self::safe($row['position'] ?? '');
            $pdf["relatives_r{$r}c4"] = self::safe($row['agency_office'] ?? '');
        }

        // Optional totals if you compute them
        $pdf['real_properties_subtotal']   = self::safe($form['assets']['real_properties_subtotal'] ?? '');
        $pdf['personal_properties_subtotal']= self::safe($form['assets']['personal_properties_subtotal'] ?? '');
        $pdf['total_assets']               = self::safe($form['assets']['total_assets'] ?? '');
        $pdf['total_liabilities']          = self::safe($form['total_liabilities'] ?? '');
        $pdf['net_worth']                  = self::safe($form['net_worth'] ?? '');

        // Ensure every required PDF field exists (if you want):
        // - You can merge with a "blank template" array of all field names => '' to guarantee keys exist.

        return $pdf;
    }
}