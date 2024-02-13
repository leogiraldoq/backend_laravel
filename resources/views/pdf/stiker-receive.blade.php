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
            <table cellSpacing="0" cellPading="0">
                <tr style="font-size: 25px;font-weight: bolder;">
                    <td style="width:50%;">{{ $sticker['customer'] }}</td>
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
                    <td style="font-size:30px;">{{ $sticker['store'] }}</td>
                </tr>
                <tr>
                    <td style="font-size:20px;">{{ $sticker['process'] }}</td>
                </tr>
                <tr>
                    <td class="backGroundBlack" style="font-size:25px">{{ $sticker['shipping'] }}</td>
                </tr>
                <tr>
                    <td style="padding: 0px; margin: 0px;">
                        <img src="data:image/jpeg;base64,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"/>
                    </td>
                    <td style="font-size:30px">{{ $sticker['stickerNumber'] }}</td>
                </tr>
            </table>
            <div style="page-break-before: allways;"></div>
        @endforeach
