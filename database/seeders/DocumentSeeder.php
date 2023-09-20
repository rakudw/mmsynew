<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use App\Models\FormDocumentType;

class DocumentSeeder extends BaseSeeder
{

    const PDF_MIME = 'application/pdf';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->walk([[
            'name' => 'Aadhaar Card',
            'mime' => self::PDF_MIME,
        ], [
            'name' => 'Himachali Bonafide Certificate',
            'mime' => self::PDF_MIME,
        ], [
            'name' => 'Age Proof',
            'mime' => self::PDF_MIME,
        ], [
            'name' => 'Preliminary Project Report',
            'mime' => self::PDF_MIME,
        ], [
            'name' => 'Applicant\'s Photograph',
            'mime' => self::PDF_MIME,
        ], [
            'name' => 'Firm Registration Certificate',
            'mime' => self::PDF_MIME,
        ], [
            'name' => 'SC/ST Certificate',
            'mime' => self::PDF_MIME,
        ], [
            'name' => 'Driving License',
            'mime' => self::PDF_MIME,
        ]], [DocumentType::class, 'create']);

        $documentTypes = DocumentType::all()->toArray();

        $order = 0;
        $this->walk(array_map(function($docType) use(&$order) {
            return [
                'form_id' => 1,
                'document_type_id' => $docType['id'],
                'order' => $order++,
                'is_required' => true,
                'extras' => $this->getExtras($docType['name']),
            ];
        }, $documentTypes), [FormDocumentType::class, 'create']);
    }

    private function getExtras(string $documentName):array|null {
        switch($documentName) {
            case 'Firm Registration Certificate':
                return [
                    'message' => 'Partnership Firm Registration/Certificate of Incorporation/Certificate of Registration by RoC/Coorporate Society Registration Certificate/Self Help Group Registration certificate',
                    'condition' => '$application->isAFirm()'
                ];
            case 'Preliminary Project Report':
                return [
                    'message' => 'Please <a href="/application/project-report/%s">download the linked file here</a>, sign and upload the scaned PDF.'
                ];
            case 'Age Proof':
                return [
                    'message' => '10th Certificate/Birth Certificate/Passport/PAN Card'
                ];
            case 'SC/ST Certificate':
                return [
                    'condition' => '$application->isSCOrST()'
                ];
            case 'Driving License':
                return [
                    'condition' => '($application->getData(\'enterprise\', \'activity_type_id\') == 202) && ($application->getData(\'enterprise\', \'activity_id\') == 84)'
                ];
            default:
                return null;
        }
    }
}