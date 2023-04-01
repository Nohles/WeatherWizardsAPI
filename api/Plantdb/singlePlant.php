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

// Instantiate blog result object
$plant = new Plantdb($db);

$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
$arr = explode(" ", $authHeader);

// Get ID
$plant->CommonName = isset($_GET['CommonName']) ? $_GET['CommonName'] : die();


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


  // Get result
  $plant->singlePlant();

  // Create array
  $plant_arr = array(
    'betydbspeciesid' => $plant->betydbspeciesid,
    'Genus' => $plant->Genus,
    'Species' => $plant->Species,
    'ScientificName' => $plant->ScientificName,
    'CommonName' => $plant->CommonName,
    'Symbol' => $plant->Symbol,
    'PLANTS_Floristic_Area' => $plant->PLANTS_Floristic_Area,
    'State' => $plant->State,
    'Family' => $plant->Family,
    'FamilyCommonName' => $plant->FamilyCommonName,
    'Kingdom' => $plant->Kingdom,
    'Duration' => $plant->Duration,
    'GrowthHabit' => $plant->GrowthHabit,
    'NativeStatus' => $plant->NativeStatus,
    'Invasive' => $plant->Invasive,
    'ActiveGrowthPeriod' => $plant->ActiveGrowthPeriod,
    'AfterHarvestRegrowthRate' => $plant->AfterHarvestRegrowthRate,
    'Bloat' => $plant->Bloat,
    'C2N_Ratio' => $plant->C2N_Ratio,
    'CoppicePotential' => $plant->CoppicePotential,
    'FallConspicuous' => $plant->FallConspicuous,
    'FireResistance' => $plant->FireResistance,
    'FlowerColor' => $plant->FlowerColor,
    'FlowerConspicuous' => $plant->FlowerConspicuous,
    'FoliageColor' => $plant->FoliageColor,
    'FoliagePorositySummer' => $plant->FoliagePorositySummer,
    'FoliagePorosityWinter' => $plant->FoliagePorosityWinter,
    'FoliageTexture' => $plant->FoliageTexture,
    'FruitColor' => $plant->FruitColor,
    'FruitConspicuous' => $plant->FruitConspicuous,
    'GrowthForm' => $plant->GrowthForm,
    'GrowthRate' => $plant->GrowthRate,
    'MaxHeight20Yrs' => $plant->MaxHeight20Yrs,
    'MatureHeight' => $plant->MatureHeight,
    'KnownAllelopath' => $plant->KnownAllelopath,
    'LeafRetention' => $plant->LeafRetention,
    'Lifespan' => $plant->Lifespan,
    'LowGrowingGrass' => $plant->LowGrowingGrass,
    'NitrogenFixation' => $plant->NitrogenFixation,
    'ResproutAbility' => $plant->ResproutAbility,
    'Shape_and_Orientation' => $plant->Shape_and_Orientation,
    'Toxicity' => $plant->Toxicity,
    'AdaptedCoarseSoils' => $plant->AdaptedCoarseSoils,
    'AdaptedMediumSoils' => $plant->AdaptedMediumSoils,
    'AdaptedFineSoils' => $plant->AdaptedFineSoils,
    'AnaerobicTolerance' => $plant->AnaerobicTolerance,
    'CaCO3Tolerance' => $plant->CaCO3Tolerance,
    'ColdStratification' => $plant->ColdStratification,
    'DroughtTolerance' => $plant->DroughtTolerance,
    'FertilityRequirement' => $plant->FertilityRequirement,
    'FireTolerance' => $plant->FireTolerance,
    'MinFrostFreeDays' => $plant->MinFrostFreeDays,
    'HedgeTolerance' => $plant->HedgeTolerance,
    'MoistureUse' => $plant->MoistureUse,
    'pH_Minimum' => $plant->pH_Minimum,
    'pH_Maximum' => $plant->pH_Maximum,
    'Min_PlantingDensity' => $plant->Min_PlantingDensity,
    'Max_PlantingDensity' => $plant->Max_PlantingDensity,
    'Precipitation_Minimum' => $plant->Precipitation_Minimum,
    'Precipitation_Maximum' => $plant->Precipitation_Maximum,
    'RootDepthMinimum' => $plant->RootDepthMinimum,
    'SalinityTolerance' => $plant->SalinityTolerance,
    'ShadeTolerance' => $plant->ShadeTolerance,
    'TemperatureMinimum' => $plant->TemperatureMinimum,
    'BloomPeriod' => $plant->BloomPeriod,
    'CommercialAvailability' => $plant->CommercialAvailability,
    'FruitSeedAbundance' => $plant->FruitSeedAbundance,
    'FruitSeedPeriodBegin' => $plant->FruitSeedPeriodBegin,
    'FruitSeedPeriodEnd' => $plant->FruitSeedPeriodEnd,
    'FruitSeedPersistence' => $plant->FruitSeedPersistence,
    'Propogated_by_BareRoot' => $plant->Propogated_by_BareRoot,
    'Propogated_by_Bulbs' => $plant->Propogated_by_Bulbs,
    'Propogated_by_Container' => $plant->Propogated_by_Container,
    'Propogated_by_Corms' => $plant->Propogated_by_Corms,
    'Propogated_by_Cuttings' => $plant->Propogated_by_Cuttings,
    'Propogated_by_Seed' => $plant->Propogated_by_Seed,
    'Propogated_by_Sod' => $plant->Propogated_by_Sod,
    'Propogated_by_Sprigs' => $plant->Propogated_by_Sprigs,
    'Propogated_by_Tubers' => $plant->Propogated_by_Tubers,
    'Seeds_per_Pound' => $plant->Seeds_per_Pound,
    'SeedSpreadRate' => $plant->SeedSpreadRate,
    'SeedlingVigor' => $plant->SeedlingVigor,
    'SmallGrain' => $plant->SmallGrain,
    'VegetativeSpreadRate' => $plant->VegetativeSpreadRate,
    'Berry_Nut_Seed_Product' => $plant->Berry_Nut_Seed_Product,
    'ChristmasTreeProduct' => $plant->ChristmasTreeProduct,
    'FodderProduct' => $plant->FodderProduct,
    'FuelwoodProduct' => $plant->FuelwoodProduct,
    'LumberProduct' => $plant->LumberProduct,
    'NavalStoreProduct' => $plant->NavalStoreProduct,
    'NurseryStockProduct' => $plant->NurseryStockProduct,
    'PalatableBrowseAnimal' => $plant->PalatableBrowseAnimal,
    'PalatableGrazeAnimal' => $plant->PalatableGrazeAnimal,
    'PalatableHuman' => $plant->PalatableHuman,
    'PostProduct' => $plant->PostProduct,
    'ProteinPotential' => $plant->ProteinPotential,
    'PulpwoodProduct' => $plant->PulpwoodProduct,
    'VeneerProduct' => $plant->VeneerProduct,

  );

  // Make JSON
  print_r(json_encode($plant_arr));
} else if ($m == "Fail") {


  echo json_encode(array(
    "message" => "Access denied.",
    "error" => $e->getMessage()
  ));
}
