<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de Tableau TEFICA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Générateur de Tableau TEFICA</h1>
        <table class="table table-bordered" id="letterTable">
            <thead>
                <tr>
                    <th></th>
                    @for ($i = 0; $i < 24; $i++)
                        <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                    @endfor
                </tr>
            </thead>

            <tbody id="tefica-table">
                @for ($i = 0; $i < 60; $i++)
                    <tr>
                        <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                        @for ($j = 0; $j < 24; $j++)
                            <td>{{ $table[$i][$j] }}</td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
        <button class="btn btn-primary" id="generate-btn">Générer</button>
        <button class="btn btn-secondary" id="export-btn">Exporter</button>
        <button class="btn btn-info" id="send-email-btn">Envoyer par mail</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('generate-btn').addEventListener('click', () => {
            axios.post('/generate').then(response => {
                const table = response.data;
                const tbody = document.getElementById('tefica-table');
                tbody.innerHTML = '';
                for (let i = 0; i < table.length; i++) {
                    let row = '<tr><th>' + String(i).padStart(2, '0') + '</th>';
                    for (let j = 0; j < table[i].length; j++) {
                        row += '<td>' + table[i][j] + '</td>';
                    }
                    row += '</tr>';
                    tbody.innerHTML += row;
                }
            });
        });

        document.getElementById('export-btn').addEventListener('click', exportTableToExcel);

        function exportTableToExcel() {
            const table = document.getElementById('letterTable');
            const rows = table.getElementsByTagName('tr');
            let data = [];

            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let row = [];
                for (let j = 0; j < cells.length; j++) {
                    row.push(cells[j].textContent);
                }
                data.push(row);
            }

            let wb = XLSX.utils.book_new();
            let ws = XLSX.utils.aoa_to_sheet(data);
            XLSX.utils.book_append_sheet(wb, ws, "Lettres Aléatoires");

            XLSX.writeFile(wb, "Tableau_Lettres_Aleatoires.xlsx");
        }

        document.getElementById('send-email-btn').addEventListener('click', () => {
            window.location.href = '/email';
        });
    </script>
</body>
</html>
