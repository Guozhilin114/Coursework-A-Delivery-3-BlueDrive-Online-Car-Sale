<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Character encoding to prevent garbled text -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developer Information</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Ensure media elements scale responsively without overflow */
        img, video, iframe { max-width: 100%; height: auto; }

        /* Fluid typography: scales font-size between mobile, tablet, and desktop */
        html { font-size: clamp(1rem, 0.75rem + 0.5vw, 1.25rem); }

        /* Adaptive grid: auto-adjusts columns based on available screen space */
        .responsive-grid { display: grid; gap: 1rem; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }

        body {
            background-color: #eee;
            /* Changed background color */
            padding: 40px 20px;
            /* Keep content from touching the edge */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
        }

        h1 {
            color: black;
            /* Darkened title color */
            text-align: center;
            /* Center the title */
            margin-bottom: 30px;
            font-size: 28px;
        }

        table {
            border: 1px solid black;
            border-collapse: collapse;
            /* Merge table borders */
            width: 100%;
            /* Make table full width */
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px #ccc;
        }

        th, td {
            border: none;
            padding: 16px;
            /* Increased padding */
        }

        th {
            background-color: blue;
            color: white;
            /* Header background color */
            text-align: left;
            font-weight: 600;
        }

        td {
            border-bottom: 1px solid #ccc;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        .name {
            font-weight: bold;
            color: black;
        }

        .student-id {
            color: #777;
        }

        .email {
            color: blue;
        }

        a {
            color: blue;
            text-decoration: none;
            /* Remove link underline */
            display: inline-block;
            margin-top: 30px;
            text-align: center;
            width: 100%;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
            /* Show underline on hover */
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Web page main content -->
        <h1>Developer Information</h1>

        <!-- Developer information table -->
        <table>
            <tr>
                <th>Name</th>
                <th>Student ID</th>
                <th>Email</th>
            </tr>
            <tr>
                <td class="name">Zhutongchen</td>
                <td class="student-id">250001572</td>
                <td class="email">jp2024213885@qmul.ac.uk</td>
            </tr>
            <tr>
                <td class="name">Guozhilin</td>
                <td class="student-id">250001642</td>
                <td class="email">jp2024213866@qmul.ac.uk</td>
            </tr>
            <tr>
                <td class="name">Liujiashen</td>
                <td class="student-id">250001675</td>
                <td class="email">jp2024213875@qmul.ac.uk</td>
            </tr>
            <tr>
                <td class="name">Zhangchenye</td>
                <td class="student-id">250001712</td>
                <td class="email">jp2024213874@qmul.ac.uk</td>
            </tr>
        </table>

        <!-- Back link -->
        <a href="search.html">← Back to Car Marketplace</a>
    </div>

</body>
</html>
