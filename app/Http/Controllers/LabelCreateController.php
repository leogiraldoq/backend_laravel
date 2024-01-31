<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Interfaces\LabelCreateContentRepositoryInterface;
use App\Interfaces\LabelCreateSizeRepositoryInterface;
use App\Traits\ResponseTrait;

class LabelCreateController extends Controller
{
    use ResponseTrait;
    
    private LabelCreateContentRepositoryInterface $labelContentRepository;
    private LabelCreateSizeRepositoryInterface $labelSizeRepository;
    
    public function __construct(
        LabelCreateContentRepositoryInterface $labelContentRepository,
        LabelCreateSizeRepositoryInterface $labelSizeRepository
    )
    {
        $this->labelContentRepository = $labelContentRepository;
        $this->labelSizeRepository = $labelSizeRepository;
    }
    
    
    /**
     * List all labels Content
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     */
    public function listAllLabelContents(){
        try {
            $labelsContent = $this->labelContentRepository->queryAllActive();
            return $this->responseOk("Label contents to create amnd print listed", $labelsContent);
        } catch (Exception $ex) {
            $this->responseError($ex->getMessage());
        }
    }
    
    /**
     * Create labels contents to print
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     */
    public function createLabelContent(Request $request){
        try {
            $dataLabelContentValidate = $request->validate([
                'titleLabelContent' => 'required|string|min:5|max:100',
                'contentLabel' => 'required|array|min:1',
                'contentLabel.*.position' => 'nullable|integer|min:1|max:15',
                'contentLabel.*.text' => 'nullable|string|min:3|max:255,'
            ]);
            $newLabelContent = $this->labelContentRepository->create($dataLabelContentValidate);
            return $this->responseOk("Label content ".$dataLabelContentValidate['titleLabelContent']." created", $newLabelContent);
        } catch (Exception $ex) {
            return $this->responseError($ex->getMessage());
        }
    }
    
    /**
     * List all labels size
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     */
    public function listAllLabelsSize(){
        try {
            $labelsSize = $this->labelSizeRepository->queryAllActive();
            return $this->responseOk("Labels size listed", $labelsSize);
        } catch (Exception $ex) {
            return $this->responseError($ex->getMessage());
        }
    }
    
    /**
     * Create labels size to print
     * @return \Illuminate\Http\JsonResponse
     * @author LeoGiraldoQ
     */
    public function createLabelsSize(Request $request){
        try {
            $dataLabelSizeValidate = $request->validate([
                "titleSize" => 'required|string|min:5|max:100',
                "listLabelSize" => 'required|array|min:1',
                "listLabelSize.*.position" => 'required|integer|min:1|max:6',
                "listLabelSize.*.size" => 'nullable|string|min:1|max:10'
            ]);
            $newLabelSize = $this->labelSizeRepository->create($dataLabelSizeValidate);
            return $this->responseOk("Label Size ".$dataLabelSizeValidate['titleSize']." created", $newLabelSize);
        } catch (Exception $ex) {
            return $this->responseError($ex->getMessage());
        }
    }
}
