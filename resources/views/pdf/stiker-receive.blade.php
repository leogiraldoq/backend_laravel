<html>
    <style>
        @page{
            size: 432pt 288pt;
        }
        @font-face {
            font-family: 'Rubik', sans-serif;
            font-style: normal;
            font-weight: normal;
            src: url(https://fonts.googleapis.com/css2?family=Rubik:wght@500&display=swap) format('truetype');
        }
        html,body{
            margin: 2px;
            padding: 0px;
        }
        .container{
            font-family: 'Rubik', sans-serif;
            width: 432pt;
            height: 288pt;
            page-break-after: allways;
            margin: 0px;
        }
        table{
            width: 100%;
            height: auto;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
            text-align: center;
            vertical-align: center;
        }
        .backGroundBlack{
            background-color: #000;
            color: #FFF;
        }
    </style>
    <body>
        @foreach ($sendToView as $sticker)
        <div class="container">
            <table cellSpacing="0" cellPading="0">
                <tr style="font-size: 25px;font-weight: bolder;">
                    <td style="width:40%;">{{ $sticker['customer'] }}</td>
                    <td>{{ $sticker['boutique'] }}</td>
                </tr>
                <tr>
                    <td rowspan="4">
                        <img src="data:image/png;base64,{{ $sticker['qr'] }}"/>
                    </td>
                    <td>
                        <small>RECEIVED ON:</small>
                        <p style="font-size:20px;margin:0px;padding:0px;">{{ $sticker['received'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:20px;">{{ $sticker['store'] }}</td>
                </tr>
                <tr>
                    <td style="font-size:20px;">{{ $sticker['process'] }}</td>
                </tr>
                <tr>
                    <td class="backGroundBlack" style="font-size:20px">{{ $sticker['shipping'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 0px; margin: 0px;">
                        <img src="data:image/png;base64,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"/>
                    </td>
                    <td style="font-size:20px">{{ $sticker['stickerNumber'] }}</td>
                </tr>
            </table>
        </div>
        @endforeach
