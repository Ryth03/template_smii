<html>

<head>
    <title>Product Change Request</title>
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Arial', sans-serif;
            border: 1px solid #000000;
            background-color: #ffffff;
            font-size: 13px;
            border-collapse: collapse;

        }

        .bordered-table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 10px;
            background-color: #fff;
        }

        .bordered-table th,
        .bordered-table td,
        .decision-table th,
        .decision-table td {
            border: 1px solid #000000;
            padding: 8px;
            font-size: 13px;
            align-items: center;
        }

        .bordered-table th {
            text-align: left;
            background-color: #ffffff;
            color: black;
        }

        .bordered-table tr:nth-child(even) {
            background-color: #ffffff;
        }

        .signature-box {
            height: 25px;
            width: 100px;
        }

        .header-section {
            align-items: center;
            border: 2px solid #0e0e0d;
            padding: 10px;
            margin-bottom: 20px;
            background-color: #ffffff;
            color: black;
            page-break-after: avoid;
        }

        .header-section img {
            width: 150px;
            margin-left: 10px;
        }

        .header-section h1 {
            font-size: 1.3rem;
            font-weight: bold;
        }

        .header-section table {
            text-align: right;
        }

        .header-section th,
        .header-section td {
            border: none;
            padding: 2px 5px;
        }

        .decision-table .signature-box {
            text-align: center;
        }

        .text-green-500 {
            color: #4CAF50;
        }

        .text-yellow-500 {
            color: #ffd900;
        }

        .text-red-500 {
            color: #F44336;
        }

        .text-danger {
            color: #dc3545;
        }

        .nature-of-change-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .description-of-change {
            word-wrap: break-word;
            max-width: 600px;
        }

        @media print {
            @page {
                size: A4;
                counter-increment: page;
            }

            body {
                margin: 0;
                padding: 0;
            }


            .header-section {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
            }

            .content {
                position: relative;
                margin-top: 130px;
            }
        }

        .bordered-table,
        .decision-table {
            page-break-inside: avoid;
            padding: 80px;
        }

        .header-section {
            page-break-after: avoid;
        }
    </style>
</head>

<body>
    <div class="header-section">
        <!-- Bagian Logo -->
        <div style="display: flex; justify-content: space-between;">
            <div>
                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo SMI">
            </div>

            <!-- Bagian Tabel -->
            <div>
                <h1>Product Change Request</h1>
            </div>
            <div>
                <table>
                    <tr>
                        <th style="font-size: 12px;">No :</th>
                        <td style="font-size: 12px;">F/S.5.1-02</td>
                    </tr>
                    <tr>
                        <th style="font-size: 12px;">Revision:</th>
                        <td style="font-size: 12px;">1</td>
                    </tr>
                    <tr>
                        <th style="font-size: 12px;">Date:</th>
                        <td style="font-size: 12px;">8-Feb-21</td>
                    </tr>
                </table>

            </div>
        </div>

        <!-- Bagian R&D dan No. Reg -->
        <div class="footer-info"
            style="display: flex; justify-content: space-between; margin-top: 10px; border-top: 1px solid #000000; padding-top: 10px;">
            <p class="font-bold" style="margin: 0;">R&amp;D - PT. SMII</p>
            <p style="margin: 0;">No. reg. : 1</p>
        </div>

    </div>



    <div class="content">
        <table class="bordered-table">
            <tr>
                <th colspan="2">Product Name:</th>
                <td colspan="5">
                Lucheng shortening Winter & Summer, Xiabdi Shortening Winter & Summer
                </td>
            </tr>
            <tr>
                <th colspan="2">Database Number:</th>
                <td colspan="5">
                X1G604-D, X1G604-E: X1G607-D, X1G607-E, X1G605-D, X1G605-E, X1G606-D, X1G606-E
                </td>
            </tr>
            <tr>
                <th colspan="2">Nature of Change:</th>
                <td colspan="5">
                    <div class="nature-of-change-grid">
                        @php 
                            $natures = [
                        'Change to Oilblend',
                        'Change to Formula',
                        'Change to Packaging',
                        'Change to Process',
                        'Change Product',
                        ]
                        @endphp
                        @foreach ($natures as $nature)
                        <div>
                            <input disabled id="{{ $nature }}" type="checkbox" checked />
                            <label for="{{ $nature }}">{{ $nature }}</label>
                        </div>
                        @endforeach
                        @php
                        $otherChanges = 'Change to Oilblend';
                        @endphp
                        <div>
                            <input disabled id="other" type="checkbox" checked  />
                            <label for="other">Other</label>
                            <input type="text" value="{{ $otherChanges }}" disabled
                                class="ml-2 border border-gray-300 p-1" />
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th colspan="2">Description of Change:</th>
                <td colspan="5" class="description-of-change">Add GACC approval number (As per Costume request) from October submission "CIDN06022112010011" temporary use ink jet print.
                After the Number fix, change it into printed carton.</td>
            </tr>
            <tr>
                <th colspan="2">Reason for Change:</th>
                <td colspan="5">General Admission of Customs of People's Republic of China Regulation as stated in Decree 248</td>
            </tr>
            <tr>
                <th colspan="2">Estimation Benefit:</th>
                <td colspan="5">maintain customer</td>
            </tr>
            <tr>
                <th colspan="2">Date Required:</th>
                <td colspan="5">Semester 1-2022</td>
            </tr>
            <tr>
                <th colspan="2">Initiator:</th>
                <td>
                Natasha Tachjadi
                </td>
                <th>Signature:</th>
                <td class="signature-box">
                Approved
                </td>
                <th>Date:</th>
                <td>
                    12-jan-22
                </td>
            </tr>
        </table>

        <table class="bordered-table" style="font-size: 14px;padding: 50px;">
            <tr>
                <th colspan="2">2. Product Development Committee:</th>
                <th>Approved No Review</th>
                <th>Approved With Review</th>
                <th>Not Approved</th>
                <th>Notes/Comments</th>
            </tr>
            @php
                $pccs = ["R&D (Coordinator)", "Product Service Ast Manager/Manager", "Marketing Manager", "Sales and Marketing Departement Head", "Quality Management Departement Head", "Manufacturing Departement Head", "Supply Chain Departement Head", "PPIC Manager", "Koordinator Auditor Halal Internal", "General Manager(chairman)" ]
            @endphp
            @foreach ($pccs as $pcc)
            <tr>
                <td colspan="2">{{ $pcc}}</td>
                <td>
                    <strong class="text-green-500 text-center text-md">APPROVED NOT REVIEW</strong>
                </td>
                <td>
                    &nbsp;
                </td>
                <td>
                    &nbsp;
                </td>
                <td></td>
            </tr>
            @endforeach
        </table>

        <table class="bordered-table decision-table" style="align-content: center;">
            <tr>
                <th>3. Decision</th>
                <td style="text-align: center;">Change</td>
                <td style="text-align: center;">Not Change</td>
                <td style="text-align: center;">Effective Date</td>
            </tr>
            <tr>
                <td class="signature-box"></td>
                <td class="signature-box text-center">

                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                        fill="none" stroke="green" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-check mx-auto">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                </td>
                <td class="signature-box text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                        fill="none" stroke="red" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="feather feather-check mx-auto">
                        <path d="M20 6L9 17l-5-5" />
                    </svg>
                </td>
                <td class="signature-box text-center">
                    12-12-2004
                </td>
            </tr>
        </table>
    </div>


</body>
<div class="page-number" style="position: fixed; bottom: 0; right: 0; padding: 5px;">
    <!-- Page number will be automatically inserted here -->
</div>

<script>
    window.onload = function() {
        setTimeout(function() {
            window.print();
        }, 1000);

        window.onbeforeunload = function() {
            return "Are you sure you want to leave? Your document is still printing.";
        };

        window.onafterprint = function() {
            window.onbeforeunload = null;
            window.close();
        };

        const content = document.querySelector('.content');
        const pageNumberElement = document.querySelector('.page-number');
        const tables = document.querySelectorAll('.bordered-table');

        function updatePageNumbers() {
            const contentHeight = content.scrollHeight;
            const viewportHeight = window.innerHeight;
            const totalPages = Math.ceil(contentHeight / viewportHeight);
            const currentPage = Math.ceil((window.scrollY + viewportHeight) / viewportHeight);
            pageNumberElement.textContent = `Page ${currentPage} of ${totalPages}`;
        }

        function checkTableCutOff() {
            tables.forEach(table => {
                const tableRect = table.getBoundingClientRect();
                const pageHeight = window.innerHeight;

                if (tableRect.bottom > pageHeight) {
                    console.warn('Table is cut off at the bottom of the page');
                    // You can add additional logic here to handle the cut-off table
                }
            });
        }

        window.addEventListener('scroll', updatePageNumbers);
        window.addEventListener('resize', updatePageNumbers);

        // Inisialisasi nomor halaman dan cek tabel saat pertama kali dimuat
        updatePageNumbers();
        checkTableCutOff();
    };
</script>

</html>