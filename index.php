<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Test eeDomus</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.2/css/bulma.min.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
  <section class="section">
    <div class="container">
      <h1 class="title">eeDomus</h1>
      <?php
      $VARIABLE = [];
      $VALUE = [];

      function setValue($key, $value) {
        global $VALUE;
        $VALUE[$key] = $value;
      }

      function getValue($key) {
        global $VALUE;
        return $VALUE[$key];
      }

      function loadVariable($key) {
        global $VARIABLE;
        return $VARIABLE[$key];
      }

      function saveVariable($key, $value) {
        global $VARIABLE;
        $VARIABLE[$key] = $value;
      }

       ?>
      <?php include_once('filterpool/filterpool.php'); ?>
    </div>
  </section>
</body>
</html>