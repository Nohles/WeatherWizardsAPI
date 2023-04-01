<?php
// Headers
header("Access-Control-Allow-Origin: http://localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/Database.php';
include_once '../../models/plantdb.php';

include_once '../../config/core.php';
include_once '../../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../../libs/php-jwt-master/src/ExpiredException.php';
include_once '../../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../../libs/php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$plantdb = new Plantdb($db);

$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$arr = explode(" ", $authHeader);



// // Get ID
// $plantdb->TemperatureMinimum = isset($_GET['TemperatureMinimum']) ? $_GET['TemperatureMinimum'] : die();
// $plantdb->MoistureUse = isset($_GET['moisture']) ? $_GET['moisture'] : die();
// $plantdb->ShadeTolerance = isset($_GET['Shade']) ? $_GET['Shade'] : die();
$var1 = isset($_GET['CommonName']) ? $_GET['CommonName'] : die();
$plantdb->CommonName = '%' . $var1 . '%';
//sciencfic
//misspelled
$var6 = isset($_GET['GrowthHabit']) ? $_GET['GrowthHabit'] : die();
$plantdb->GrowthHabit = '%' . $var6 . '%';
$var4 = isset($_GET['season']) ? $_GET['season'] : die();
$plantdb->ActiveGrowthPeriod = '%' . $var4 . '%';
$var5 = isset($_GET['State']) ? $_GET['State'] : die();
$plantdb->State = '%' . $var5 . '%';
$var7 = isset($_GET['BloomPeriod']) ? $_GET['BloomPeriod'] : die();
$plantdb->BloomPeriod = '%' . $var7 . '%';
$var8 = isset($_GET['CommercialAvailability']) ? $_GET['CommercialAvailability'] : die();
$plantdb->CommercialAvailability = '%' . $var8 . '%';
$var9 = isset($_GET['DroughtTolerance']) ? $_GET['DroughtTolerance'] : die();
$plantdb->DroughtTolerance = '%' . $var9 . '%';
$plantdb->PalatableHuman = isset($_GET['PalatableHuman']) ? $_GET['PalatableHuman'] : die();

// $plantdb->PalatableHuman = '%'.$var10.'%';
// if($var10 = true){
//   $plantdb->PalatableHuman = "Yes";

// }else if($var10 = false){
//   $plantdb->PalatableHuman = "No";
// }

// $var11 = isset($_GET['NativeStatus']) ? $_GET['NativeStatus'] : die();
// $plantdb->NativeStatus = '%'.$var11.'%';



//$plantdb->TemperatureMinimum = '%'.$var.'%';


$m = "T";

$jwt = $arr[1];
if ($jwt) {
  // if decode succeed, show user details
  // decode jwt
  try {
    $decoded = JWT::decode($jwt, $key, array('HS256'));
    $m = "Success";
  } catch (Exception $e) {

    $m = "Fail";
  }
}

if ($m == "Success") {


  $result = $plantdb->searchPlants();
  // Get row count
  $num = $result->rowCount();

  if ($num > 0) {

    $plant_arr = array();


    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $plant_item = array(
        'betydbspeciesid' => $betydbspeciesid,
        'Genus' => $Genus,
        'Species' => $Species,
        'ScientificName' => $ScientificName,
        'CommonName' => $CommonName,
        'Symbol' => $Symbol,
        'PLANTS_Floristic_Area' => $PLANTS_Floristic_Area,
        'State' => $State,
        'Family' => $Family,
        'FamilyCommonName' => $FamilyCommonName,
        'Kingdom' => $Kingdom,
        'Duration' => $Duration,
        'GrowthHabit' => $GrowthHabit,
        'NativeStatus' => $NativeStatus,
        'Invasive' => $Invasive,
        'ActiveGrowthPeriod' => $ActiveGrowthPeriod,
        'AfterHarvestRegrowthRate' => $AfterHarvestRegrowthRate,
        'Bloat' => $Bloat,
        'C2N_Ratio' => $C2N_Ratio,
        'CoppicePotential' => $CoppicePotential,
        'FallConspicuous' => $FallConspicuous,
        'FireResistance' => $FireResistance,
        'FlowerColor' => $FlowerColor,
        'FlowerConspicuous' => $FlowerConspicuous,
        'FoliageColor' => $FoliageColor,
        'FoliagePorositySummer' => $FoliagePorositySummer,
        'FoliagePorosityWinter' => $FoliagePorosityWinter,
        'FoliageTexture' => $FoliageTexture,
        'FruitColor' => $FruitColor,
        'FruitConspicuous' => $FruitConspicuous,
        'GrowthForm' => $GrowthForm,
        'GrowthRate' => $GrowthRate,
        'MaxHeight20Yrs' => $MaxHeight20Yrs,
        'MatureHeight' => $MatureHeight,
        'KnownAllelopath' => $KnownAllelopath,
        'LeafRetention' => $LeafRetention,
        'Lifespan' => $Lifespan,
        'LowGrowingGrass' => $LowGrowingGrass,
        'NitrogenFixation' => $NitrogenFixation,
        'ResproutAbility' => $ResproutAbility,
        'Shape_and_Orientation' => $Shape_and_Orientation,
        'Toxicity' => $Toxicity,
        'AdaptedCoarseSoils' => $AdaptedCoarseSoils,
        'AdaptedMediumSoils' => $AdaptedMediumSoils,
        'AdaptedFineSoils' => $AdaptedFineSoils,
        'AnaerobicTolerance' => $AnaerobicTolerance,
        'CaCO3Tolerance' => $CaCO3Tolerance,
        'ColdStratification' => $ColdStratification,
        'DroughtTolerance' => $DroughtTolerance,
        'FertilityRequirement' => $FertilityRequirement,
        'FireTolerance' => $FireTolerance,
        'MinFrostFreeDays' => $MinFrostFreeDays,
        'HedgeTolerance' => $HedgeTolerance,
        'MoistureUse' => $MoistureUse,
        'pH_Minimum' => $pH_Minimum,
        'pH_Maximum' => $pH_Maximum,
        'Min_PlantingDensity' => $Min_PlantingDensity,
        'Max_PlantingDensity' => $Max_PlantingDensity,
        'Precipitation_Minimum' => $Precipitation_Minimum,
        'Precipitation_Maximum' => $Precipitation_Maximum,
        'RootDepthMinimum' => $RootDepthMinimum,
        'SalinityTolerance' => $SalinityTolerance,
        'ShadeTolerance' => $ShadeTolerance,
        'TemperatureMinimum' => $TemperatureMinimum,
        'BloomPeriod' => $BloomPeriod,
        'CommercialAvailability' => $CommercialAvailability,
        'FruitSeedAbundance' => $FruitSeedAbundance,
        'FruitSeedPeriodBegin' => $FruitSeedPeriodBegin,
        'FruitSeedPeriodEnd' => $FruitSeedPeriodEnd,
        'FruitSeedPersistence' => $FruitSeedPersistence,
        'Propogated_by_BareRoot' => $Propogated_by_BareRoot,
        'Propogated_by_Bulbs' => $Propogated_by_Bulbs,
        'Propogated_by_Container' => $Propogated_by_Container,
        'Propogated_by_Corms' => $Propogated_by_Corms,
        'Propogated_by_Cuttings' => $Propogated_by_Cuttings,
        'Propogated_by_Seed' => $Propogated_by_Seed,
        'Propogated_by_Sod' => $Propogated_by_Sod,
        'Propogated_by_Sprigs' => $Propogated_by_Sprigs,
        'Propogated_by_Tubers' => $Propogated_by_Tubers,
        'Seeds_per_Pound' => $Seeds_per_Pound,
        'SeedSpreadRate' => $SeedSpreadRate,
        'SeedlingVigor' => $SeedlingVigor,
        'SmallGrain' => $SmallGrain,
        'VegetativeSpreadRate' => $VegetativeSpreadRate,
        'Berry_Nut_Seed_Product' => $Berry_Nut_Seed_Product,
        'ChristmasTreeProduct' => $ChristmasTreeProduct,
        'FodderProduct' => $FodderProduct,
        'FuelwoodProduct' => $FuelwoodProduct,
        'LumberProduct' => $LumberProduct,
        'NavalStoreProduct' => $NavalStoreProduct,
        'NurseryStockProduct' => $NurseryStockProduct,
        'PalatableBrowseAnimal' => $PalatableBrowseAnimal,
        'PalatableGrazeAnimal' => $PalatableGrazeAnimal,
        'PalatableHuman' => $PalatableHuman,
        'PostProduct' => $PostProduct,
        'ProteinPotential' => $ProteinPotential,
        'PulpwoodProduct' => $PulpwoodProduct,
        'VeneerProduct' => $VeneerProduct,
      );

      // Push to "data"
      array_push($plant_arr, $plant_item);
    }

    // Turn to JSON & output
    echo json_encode($plant_arr);
  } else {
    // No Plants
    echo json_encode(
      array('message' => 'No plants Found')
    );
  }
} else if ($m == "Fail") {


  echo json_encode(array(
    "message" => "Access denied.",
    "error" => $e->getMessage()
  ));
}
