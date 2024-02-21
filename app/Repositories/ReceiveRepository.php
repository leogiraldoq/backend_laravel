<?php

namespace App\Repositories;

use App\Interfaces\ReceiveRepositoryInterface;
use App\Models\Receive;
use App\Models\ReceiveDetails;
use App\Models\ReceiveSupports;
use Carbon\Carbon;
use App\Interfaces\ReceiveDetailsRepositoryInterface;

class ReceiveRepository implements ReceiveRepositoryInterface{
    
    private ReceiveDetailsRepositoryInterface $receiveDetailRepository;
    
    public function __construct(ReceiveDetailsRepositoryInterface $receiveDetailRepository) {
        $this->receiveDetailRepository = $receiveDetailRepository;
    }
    
    /**
     * Create a new receive boxes and details
     * @return Model
     * @author LeoGiraldoQ
     */
    public function create($newRecibe){
        $createReceive = Receive::create([
            'follow_number' => Carbon::now()->timestamp,
            'user_id' => $newRecibe['user'],
            'shipper_id' => $newRecibe['shipper']['id_shipper'],
            'customer_id' => $newRecibe['customer']['id_costumer'],
            'observations' => $newRecibe['observations'],
            'photo' => $newRecibe['photo'],
            'its_process' => $newRecibe['process'],
        ]);
        foreach($newRecibe['receive'] as $details){
            $details['receiveId'] = $createReceive['id_receive'];
            $this->receiveDetailRepository->create($details);
        }
        $receiving['ticket'] = $this->index($createReceive['id_receive']);
        $receiving['resume'] = $this->receiveDetailRepository->queryByIdReceieving($createReceive['id_receive']);
        return $receiving;
    }
    
    /**
     * Show specific receive whit details
     * @return Model
     * @author LeoGiraldoQ
     */
    public function index($idReceive){
        return Receive::with([
            'user',
            'user.employee',
            'customer',
            'shipper',
            'receive_details',
            'receive_details.boutiques',
            'receive_details.boxes',
            'receive_details.boxes.products'
        ])->where('id_receive',$idReceive)->firstOrFail()->toArray();
    }
    
    /**
     * Query the receive resume filter by one date
     * @param Date $date Date to filter in the query
     * @return Model Return a list of coincidences
     * @author LeoGiraldoQ
     */
    public function queryByDate($date){
        return Receive::with([
            'user',
            'user.employee',
            'customer',
            'shipper',
            'receive_details',
            'receive_details.boutiques',
            'receive_details.boxes'
        ])->whereBetween('created_at', [$date.' 00:00:00', $date.' 23:59:59'])->get()->toArray();
    }
    
    
    /**
     * Order the query for show in compact mode
     * @param Array $dataArray result for the query
     * @return Array Order data
     * @author LeoGiraldoQ
     */
    private function orderResults($array){
        return array_map(function($record){
            $orderDataForResume['id_receive'] = $record['id_receive'];
            $orderDataForResume['follow_number'] = $record['follow_number'];
            $orderDataForResume['shipper'] = $record['shipper']['name'];
            $orderDataForResume['customer'] = $record['customer']['name'];
            $orderDataForResume['user'] = $record['user']['employee']['names'];
            $orderDataForResume['details'] = array_map(function($details){
                $orderDetails['boutique'] = $details['boutiques']['name'];
                $orderDetails['box'] = $details['boxes']['describe']." ".$details['boxes']['dimensions'];
                $orderDetails['quantit'] = $details['quantity_box'];
                $orderDetails['weight'] = $details['weight_box'];
                return $orderDetails;
            },$record['receive_details']);
            return $orderDataForResume;
        },$array);
    }
    
    /**
     * List all receive data
     * @return Model
     * @author LeoGiraldoQ
     */
    public function showAll(){
        return Receive::with([
            'user',
            'user.employee',
            'customer',
            'shipper',
            'receive_details',
            'receive_details.boutiques',
            'receive_details.boxes'
        ])->get()->toArray();
    }
    
    /**
     * Delete receive
     * @return Model
     * @author LeoGiraldoQ
     */
    public function delete($idB64Receive){
        $receiveDetails = ReceiveDetails::where('receive_id',base64_decode($idB64Receive))->delete();
        $receiveSupports = ReceiveSupports::where('receive_id',base64_decode($idB64Receive))->delete();
        return Receive::where('id_receive', base64_decode($idB64Receive))->delete();
    }
    
}
     