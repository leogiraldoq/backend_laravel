<html>
    <style>
        @page{
            margin-top: 0px; 
            margin-bottom: 0px;
        }
        @font-face {
            font-family: 'Rubik', sans-serif;
            font-style: normal;
            font-weight: normal;
            src: url(https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap) format('truetype');
        }
        html,body{
            text-align: center;
            font-size: 14px;
        }
        small{
            font-size: 10px;
        }
        table{
            margin-left: 3px;
        }
        table,tr,th,td{
            text-align: center;
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <body>
        <div>
            <img src="data:image/jpeg;base64,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"/>
            <b>Shipping Receipt # {{ $pdfData['ticketNumber'] }}</b><br/>
            <small>1316 STANFORD AV. UNIT -A LOS ANGELES CA 90021</small><br/>
            <small>PHONE (562)835-2515 and (323)274-8378</small><br/>
            <small>bluestarpacking@gmail.com</small><br/>
            <small>www.bluestarpackingla.com</small><br/>
            <p>
                <b>Customer:</b> {{ $pdfData['customer'] }}<br/>
                <b>Date receive:</b> {{ $pdfData['dateDelivery'] }}<br/>
                <b>Shipp By:</b> {{ $pdfData['whodelivery'] }}
            </p>
            
            <p>Resume shipped:</p>
            <table>
                <tr>
                    <th>Quant</th>
                    <th>Store</th>
                    <th>Prod</th>
                    <th>Size</th>
                    <th>WT(Lbs)</th>
                </tr>
                @foreach ($pdfData['resume'] as $ticket)
                    <tr>
                        <td>{{$ticket['quantity']}}</td>
                        <td>{{$ticket['stores']}}</td>
                        <td>{{$ticket['product']}}</td>
                        <td>{{$ticket['size']}}</td>
                        <td>{{$ticket['weight']}}</td>
                    </tr>
                @endforeach
            </table>
            <p>
                <b>Pick Up Company:</b> {{ $pdfData['pickUpCompany'] }}<br/>
                <b>Pick Up By:</b> {{ $pdfData['pickUpNames'] }}<br/><br/>
                <img src="{{ $pdfData['pickUpSign'] }}" style="width: 75%;"/><br/>
                <small>Signature</small>
            </p>
            <b>Important Notice:</b> Your satisfaction is our motivation to be the best in the Los Angeles Fashion District Area... Your merchandise was handled with the best quality standars by the highly qualified personnel of our company... Feel free to contact us for any questions, complains or suggestions. To customer service +1 (323) 274-8378 Monday to Friday from 10 AM to 5 PM Pacific time or Visit our website wwww.bluestarpackingla.com. Thank You... We apreciate your bussines... BlueStar Packing INC. is not responsable for any kind of items or merchandise after 30 days.<br/>
            <b>Our purpouse is your satisfaction...</b>
        </div>
    </body>
</html>