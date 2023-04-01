<?php 
  class Plantdb {
    // DB stuff
    private $conn;

    // Plant Properties
    public $betydbspeciesid;
    public $Genus;
    public $Species;
    public $ScientificName;
    public $CommonName;
    public $Symbol;
    public $PLANTS_Floristic_Area;
    public $State;
    public $Family;
    public $FamilyCommonName;
    public $Kingdom;
    public $Duration;
    public $GrowthHabit;
    public $NativeStatus;
    public $Invasive;
    public $ActiveGrowthPeriod;
    public $AfterHarvestRegrowthRate;
    public $Bloat;
    public $C2N_Ratio;
    public $CoppicePotential;
    public $FallConspicuous;
    public $FireResistance;
    public $FlowerColor;
    public $FlowerConspicuous;
    public $FoliageColor;
    public $FoliagePorositySummer;
    public $FoliagePorosityWinter;
    public $FoliageTexture;
    public $FruitColor;
    public $FruitConspicuous;
    public $GrowthForm;
    public $GrowthRate;
    public $MaxHeight20Yrs;
    public $MatureHeight;
    public $KnownAllelopath;
    public $LeafRetention;
    public $Lifespan;
    public $LowGrowingGrass;
    public $NitrogenFixation;
    public $ResproutAbility;
    public $Shape_and_Orientation;
    public $Toxicity;
    public $AdaptedCoarseSoils;
    public $AdaptedMediumSoils;
    public $AdaptedFineSoils;
    public $AnaerobicTolerance;
    public $CaCO3Tolerance;
    public $ColdStratification;
    public $DroughtTolerance;
    public $FertilityRequirement;
    public $FireTolerance;
    public $MinFrostFreeDays;
    public $HedgeTolerance;
    public $MoistureUse;
    public $pH_Minimum;
    public $pH_Maximum;
    public $Min_PlantingDensity;
    public $Max_PlantingDensity;
    public $Precipitation_Minimum;
    public $Precipitation_Maximum;
    public $RootDepthMinimum;
    public $SalinityTolerance;
    public $ShadeTolerance;
    public $TemperatureMinimum;
    public $BloomPeriod;
    public $CommercialAvailability;
    public $FruitSeedAbundance;
    public $FruitSeedPeriodBegin;
    public $FruitSeedPeriodEnd;
    public $FruitSeedPersistence;
    public $Propogated_by_BareRoot;
    public $Propogated_by_Bulbs;
    public $Propogated_by_Container;
    public $Propogated_by_Corms;
    public $Propogated_by_Cuttings;
    public $Propogated_by_Seed;
    public $Propogated_by_Sod;
    public $Propogated_by_Sprigs;
    public $Propogated_by_Tubers;
    public $Seeds_per_Pound;
    public $SeedSpreadRate;
    public $SeedlingVigor;
    public $SmallGrain;
    public $VegetativeSpreadRate;
    public $Berry_Nut_Seed_Product;
    public $ChristmasTreeProduct;
    public $FodderProduct;
    public $FuelwoodProduct;
    public $LumberProduct;
    public $NavalStoreProduct;
    public $NurseryStockProduct;
    public $PalatableBrowseAnimal;
    public $PalatableGrazeAnimal;
    public $PalatableHuman;
    public $PostProduct;
    public $ProteinPotential;
    public $PulpwoodProduct;
    public $VeneerProduct;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    public function read() {
      // Create query
      $query = 'SELECT betydbspeciesid, Genus, Species, ScientificName, CommonName,
      Symbol, PLANTS_Floristic_Area, "State", Family,
      FamilyCommonName, Kingdom, Duration, GrowthHabit, NativeStatus, Invasive, ActiveGrowthPeriod, AfterHarvestRegrowthRate, Bloat, C2N_Ratio, CoppicePotential, FallConspicuous, FireResistance, FlowerColor, FlowerConspicuous, FoliageColor, FoliagePorositySummer, FoliagePorosityWinter, FoliageTexture, FruitColor, FruitConspicuous, GrowthForm, GrowthRate, MaxHeight20Yrs, MatureHeight, KnownAllelopath, LeafRetention, Lifespan, LowGrowingGrass, NitrogenFixation, ResproutAbility, Shape_and_Orientation, Toxicity, AdaptedCoarseSoils, AdaptedMediumSoils, AdaptedFineSoils, AnaerobicTolerance, CaCO3Tolerance, ColdStratification, DroughtTolerance, FertilityRequirement, FireTolerance, MinFrostFreeDays, HedgeTolerance, MoistureUse, pH_Minimum, pH_Maximum, Min_PlantingDensity, Max_PlantingDensity, Precipitation_Minimum, Precipitation_Maximum, RootDepthMinimum, SalinityTolerance, ShadeTolerance, TemperatureMinimum, BloomPeriod, CommercialAvailability, FruitSeedAbundance, FruitSeedPeriodBegin, FruitSeedPeriodEnd, FruitSeedPersistence, Propogated_by_BareRoot, Propogated_by_Bulbs, Propogated_by_Container, Propogated_by_Corms, Propogated_by_Cuttings, Propogated_by_Seed, Propogated_by_Sod, Propogated_by_Sprigs, Propogated_by_Tubers, Seeds_per_Pound, SeedSpreadRate, SeedlingVigor, SmallGrain, VegetativeSpreadRate, Berry_Nut_Seed_Product, ChristmasTreeProduct, FodderProduct, FuelwoodProduct, LumberProduct, NavalStoreProduct, NurseryStockProduct, PalatableBrowseAnimal, PalatableGrazeAnimal, PalatableHuman, PostProduct, ProteinPotential, PulpwoodProduct, VeneerProduct FROM Plant.plantdb';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);
      
      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single plant data 
      //where common name
    public function read_single() {
      
          // Create query
          $query = 'SELECT * FROM Plant.plantdb Where CommonName like ? ';         
          // Prepare statement
          $stmt = $this->conn->prepare($query);
          //echo $this->CommonName;
          // Bind ID
          
          $stmt->bindValue(1, $this->CommonName);

          //echo $this->CN;
          // Execute query
          $stmt->execute();
          
          return $stmt;

    }


    public function search() {
      
      // Create query
       //$query = 'SELECT * FROM Plant.plantdb Where temperatureMinimum <= ? and MoistureUse = ?  and ShadeTolerance = ? and ActiveGrowthPeriod like ? and plantdb.State like ? ;';         
      $query = 'SELECT * FROM Plant.plantdb Where temperatureMinimum <= ? and MoistureUse = ? and ShadeTolerance = ?and ActiveGrowthPeriod like ? and plantdb.State like ?  and  pH_Minimum <= ? and pH_Maximum >= ?;';
      // Prepare statement
      //echo $query;
      $stmt = $this->conn->prepare($query);
     
      // Bind ID
      
      $stmt->bindValue(1, "".$this->temperatureMinimum);
      $stmt->bindValue(2, "".$this->MoistureUse);
      $stmt->bindValue(3, "".$this->ShadeTolerance);
      $stmt->bindValue(4, "".$this->ActiveGrowthPeriod);
      $stmt->bindValue(5, "".$this->State);
      $stmt->bindValue(6, "".$this->pH_Minimum);
      $stmt->bindValue(7, "".$this->pH_Minimum);

      //echo $this->CN;
      // Execute query
      $stmt->execute();
      
      return $stmt;

  }

  public function searchAdv() {
      
    // Create query
     //$query = 'SELECT * FROM Plant.plantdb Where temperatureMinimum <= ? and MoistureUse = ?  and ShadeTolerance = ? and ActiveGrowthPeriod like ? and plantdb.State like ? ;';         
    $query = 'SELECT * FROM Plant.plantdb Where temperatureMinimum <= ? and MoistureUse = ?  and ShadeTolerance = ? and  GrowthHabit like ? and ActiveGrowthPeriod like ? and 
    BloomPeriod like ? and plantdb.State like ? and CommercialAvailability like ? 
    and DroughtTolerance like ? and PalatableHuman = ? and  pH_Minimum <= ? and pH_Maximum >= ?;';
    // Prepare statement
    //echo $query;
    $stmt = $this->conn->prepare($query);
   
    // Bind ID
    
    $stmt->bindValue(1, "".$this->TemperatureMinimum);
    $stmt->bindValue(2, "".$this->MoistureUse);
    $stmt->bindValue(3, "".$this->ShadeTolerance);
    $stmt->bindValue(4, "".$this->GrowthHabit);
    $stmt->bindValue(5, "".$this->ActiveGrowthPeriod);
    $stmt->bindValue(6, "".$this->BloomPeriod);
    $stmt->bindValue(7, "".$this->State);
    $stmt->bindValue(8, "".$this->CommercialAvailability);
    $stmt->bindValue(9, "".$this->DroughtTolerance);
    $stmt->bindValue(10, "".$this->PalatableHuman);
    $stmt->bindValue(11, "".$this->pH_Minimum);
    $stmt->bindValue(12, "".$this->pH_Minimum);
    // $stmt->bindValue(11, "".$this->NativeStatus);


    //echo $this->CN;
    // Execute query
    $stmt->execute();
    
    return $stmt;

}



public function searchPlants() {
      
  // Create query
   //$query = 'SELECT * FROM Plant.plantdb Where temperatureMinimum <= ? and MoistureUse = ?  and ShadeTolerance = ? and ActiveGrowthPeriod like ? and plantdb.State like ? ;';         
  $query = 'SELECT * FROM Plant.plantdb Where CommonName like ? and GrowthHabit like ? and ActiveGrowthPeriod like ? and 
  BloomPeriod like ? and plantdb.State like ? and CommercialAvailability like ? 
  and DroughtTolerance like ? and PalatableHuman = ? ;';
  // Prepare statement
  //echo $query;
  $stmt = $this->conn->prepare($query);
 
  // Bind ID
  
  // $stmt->bindValue(1, "".$this->temperatureMinimum);
  // $stmt->bindValue(2, "".$this->MoistureUse);
  // $stmt->bindValue(3, "".$this->ShadeTolerance);
  $stmt->bindValue(1, "".$this->CommonName);
  $stmt->bindValue(2, "".$this->GrowthHabit);
  $stmt->bindValue(3, "".$this->ActiveGrowthPeriod);
  $stmt->bindValue(4, "".$this->BloomPeriod);
  $stmt->bindValue(5, "".$this->State);
  $stmt->bindValue(6, "".$this->CommercialAvailability);
  $stmt->bindValue(7, "".$this->DroughtTolerance);
  $stmt->bindValue(8, "".$this->PalatableHuman);
  // $stmt->bindValue(11, "".$this->NativeStatus);


  //echo $this->CN;
  // Execute query
  $stmt->execute();
  
  return $stmt;

}

 // Get Single sensors data
 public function singlePlant() {
  // Create query
  $query = 'SELECT * FROM Plant.plantdb Where CommonName = ?';

  // Prepare statement
  $stmt = $this->conn->prepare($query);

  // Bind ID
  $stmt->bindParam(1, $this->CommonName);

  // Execute query
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  // Set properties
  $this->betydbspeciesid = $row['betydbspeciesid'];
$this->Genus = $row['Genus'];
$this->Species = $row['Species'];
$this->ScientificName = $row['ScientificName'];
$this->CommonName = $row['CommonName'];
$this->Symbol = $row['Symbol'];
$this->PLANTS_Floristic_Area = $row['PLANTS_Floristic_Area'];
$this->State = $row['State'];
$this->Family = $row['Family'];
$this->FamilyCommonName = $row['FamilyCommonName'];
$this->Kingdom = $row['Kingdom'];
$this->Duration = $row['Duration'];
$this->GrowthHabit = $row['GrowthHabit'];
$this->NativeStatus = $row['NativeStatus'];
$this->Invasive = $row['Invasive'];
$this->ActiveGrowthPeriod = $row['ActiveGrowthPeriod'];
$this->AfterHarvestRegrowthRate = $row['AfterHarvestRegrowthRate'];
$this->Bloat = $row['Bloat'];
$this->C2N_Ratio = $row['C2N_Ratio'];
$this->CoppicePotential = $row['CoppicePotential'];
$this->FallConspicuous = $row['FallConspicuous'];
$this->FireResistance = $row['FireResistance'];
$this->FlowerColor = $row['FlowerColor'];
$this->FlowerConspicuous = $row['FlowerConspicuous'];
$this->FoliageColor = $row['FoliageColor'];
$this->FoliagePorositySummer = $row['FoliagePorositySummer'];
$this->FoliagePorosityWinter = $row['FoliagePorosityWinter'];
$this->FoliageTexture = $row['FoliageTexture'];
$this->FruitColor = $row['FruitColor'];
$this->FruitConspicuous = $row['FruitConspicuous'];
$this->GrowthForm = $row['GrowthForm'];
$this->GrowthRate = $row['GrowthRate'];
$this->MaxHeight20Yrs = $row['MaxHeight20Yrs'];
$this->MatureHeight = $row['MatureHeight'];
$this->KnownAllelopath = $row['KnownAllelopath'];
$this->LeafRetention = $row['LeafRetention'];
$this->Lifespan = $row['Lifespan'];
$this->LowGrowingGrass = $row['LowGrowingGrass'];
$this->NitrogenFixation = $row['NitrogenFixation'];
$this->ResproutAbility = $row['ResproutAbility'];
$this->Shape_and_Orientation = $row['Shape_and_Orientation'];
$this->Toxicity = $row['Toxicity'];
$this->AdaptedCoarseSoils = $row['AdaptedCoarseSoils'];
$this->AdaptedMediumSoils = $row['AdaptedMediumSoils'];
$this->AdaptedFineSoils = $row['AdaptedFineSoils'];
$this->AnaerobicTolerance = $row['AnaerobicTolerance'];
$this->CaCO3Tolerance = $row['CaCO3Tolerance'];
$this->ColdStratification = $row['ColdStratification'];
$this->DroughtTolerance = $row['DroughtTolerance'];
$this->FertilityRequirement = $row['FertilityRequirement'];
$this->FireTolerance = $row['FireTolerance'];
$this->MinFrostFreeDays = $row['MinFrostFreeDays'];
$this->HedgeTolerance = $row['HedgeTolerance'];
$this->MoistureUse = $row['MoistureUse'];
$this->pH_Minimum = $row['pH_Minimum'];
$this->pH_Maximum = $row['pH_Maximum'];
$this->Min_PlantingDensity = $row['Min_PlantingDensity'];
$this->Max_PlantingDensity = $row['Max_PlantingDensity'];
$this->Precipitation_Minimum = $row['Precipitation_Minimum'];
$this->Precipitation_Maximum = $row['Precipitation_Maximum'];
$this->RootDepthMinimum = $row['RootDepthMinimum'];
$this->SalinityTolerance = $row['SalinityTolerance'];
$this->ShadeTolerance = $row['ShadeTolerance'];
$this->TemperatureMinimum = $row['TemperatureMinimum'];
$this->BloomPeriod = $row['BloomPeriod'];
$this->CommercialAvailability = $row['CommercialAvailability'];
$this->FruitSeedAbundance = $row['FruitSeedAbundance'];
$this->FruitSeedPeriodBegin = $row['FruitSeedPeriodBegin'];
$this->FruitSeedPeriodEnd = $row['FruitSeedPeriodEnd'];
$this->FruitSeedPersistence = $row['FruitSeedPersistence'];
$this->Propogated_by_BareRoot = $row['Propogated_by_BareRoot'];
$this->Propogated_by_Bulbs = $row['Propogated_by_Bulbs'];
$this->Propogated_by_Container = $row['Propogated_by_Container'];
$this->Propogated_by_Corms = $row['Propogated_by_Corms'];
$this->Propogated_by_Cuttings = $row['Propogated_by_Cuttings'];
$this->Propogated_by_Seed = $row['Propogated_by_Seed'];
$this->Propogated_by_Sod = $row['Propogated_by_Sod'];
$this->Propogated_by_Sprigs = $row['Propogated_by_Sprigs'];
$this->Propogated_by_Tubers = $row['Propogated_by_Tubers'];
$this->Seeds_per_Pound = $row['Seeds_per_Pound'];
$this->SeedSpreadRate = $row['SeedSpreadRate'];
$this->SeedlingVigor = $row['SeedlingVigor'];
$this->SmallGrain = $row['SmallGrain'];
$this->VegetativeSpreadRate = $row['VegetativeSpreadRate'];
$this->Berry_Nut_Seed_Product = $row['Berry_Nut_Seed_Product'];
$this->ChristmasTreeProduct = $row['ChristmasTreeProduct'];
$this->FodderProduct = $row['FodderProduct'];
$this->FuelwoodProduct = $row['FuelwoodProduct'];
$this->LumberProduct = $row['LumberProduct'];
$this->NavalStoreProduct = $row['NavalStoreProduct'];
$this->NurseryStockProduct = $row['NurseryStockProduct'];
$this->PalatableBrowseAnimal = $row['PalatableBrowseAnimal'];
$this->PalatableGrazeAnimal = $row['PalatableGrazeAnimal'];
$this->PalatableHuman = $row['PalatableHuman'];
$this->PostProduct = $row['PostProduct'];
$this->ProteinPotential = $row['ProteinPotential'];
$this->PulpwoodProduct = $row['PulpwoodProduct'];
$this->VeneerProduct = $row['VeneerProduct'];

}

 // Get Single sensors data
 public function singlePlantID() {
  // Create query
  $query = 'SELECT * FROM Plant.plantdb Where betydbspeciesid = ?';

  // Prepare statement
  $stmt = $this->conn->prepare($query);

  // Bind ID
  $stmt->bindParam(1, $this->betydbspeciesid);

  // Execute query
  $stmt->execute();

  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  // Set properties
  $this->betydbspeciesid = $row['betydbspeciesid'];
$this->Genus = $row['Genus'];
$this->Species = $row['Species'];
$this->ScientificName = $row['ScientificName'];
$this->CommonName = $row['CommonName'];
$this->Symbol = $row['Symbol'];
$this->PLANTS_Floristic_Area = $row['PLANTS_Floristic_Area'];
$this->State = $row['State'];
$this->Family = $row['Family'];
$this->FamilyCommonName = $row['FamilyCommonName'];
$this->Kingdom = $row['Kingdom'];
$this->Duration = $row['Duration'];
$this->GrowthHabit = $row['GrowthHabit'];
$this->NativeStatus = $row['NativeStatus'];
$this->Invasive = $row['Invasive'];
$this->ActiveGrowthPeriod = $row['ActiveGrowthPeriod'];
$this->AfterHarvestRegrowthRate = $row['AfterHarvestRegrowthRate'];
$this->Bloat = $row['Bloat'];
$this->C2N_Ratio = $row['C2N_Ratio'];
$this->CoppicePotential = $row['CoppicePotential'];
$this->FallConspicuous = $row['FallConspicuous'];
$this->FireResistance = $row['FireResistance'];
$this->FlowerColor = $row['FlowerColor'];
$this->FlowerConspicuous = $row['FlowerConspicuous'];
$this->FoliageColor = $row['FoliageColor'];
$this->FoliagePorositySummer = $row['FoliagePorositySummer'];
$this->FoliagePorosityWinter = $row['FoliagePorosityWinter'];
$this->FoliageTexture = $row['FoliageTexture'];
$this->FruitColor = $row['FruitColor'];
$this->FruitConspicuous = $row['FruitConspicuous'];
$this->GrowthForm = $row['GrowthForm'];
$this->GrowthRate = $row['GrowthRate'];
$this->MaxHeight20Yrs = $row['MaxHeight20Yrs'];
$this->MatureHeight = $row['MatureHeight'];
$this->KnownAllelopath = $row['KnownAllelopath'];
$this->LeafRetention = $row['LeafRetention'];
$this->Lifespan = $row['Lifespan'];
$this->LowGrowingGrass = $row['LowGrowingGrass'];
$this->NitrogenFixation = $row['NitrogenFixation'];
$this->ResproutAbility = $row['ResproutAbility'];
$this->Shape_and_Orientation = $row['Shape_and_Orientation'];
$this->Toxicity = $row['Toxicity'];
$this->AdaptedCoarseSoils = $row['AdaptedCoarseSoils'];
$this->AdaptedMediumSoils = $row['AdaptedMediumSoils'];
$this->AdaptedFineSoils = $row['AdaptedFineSoils'];
$this->AnaerobicTolerance = $row['AnaerobicTolerance'];
$this->CaCO3Tolerance = $row['CaCO3Tolerance'];
$this->ColdStratification = $row['ColdStratification'];
$this->DroughtTolerance = $row['DroughtTolerance'];
$this->FertilityRequirement = $row['FertilityRequirement'];
$this->FireTolerance = $row['FireTolerance'];
$this->MinFrostFreeDays = $row['MinFrostFreeDays'];
$this->HedgeTolerance = $row['HedgeTolerance'];
$this->MoistureUse = $row['MoistureUse'];
$this->pH_Minimum = $row['pH_Minimum'];
$this->pH_Maximum = $row['pH_Maximum'];
$this->Min_PlantingDensity = $row['Min_PlantingDensity'];
$this->Max_PlantingDensity = $row['Max_PlantingDensity'];
$this->Precipitation_Minimum = $row['Precipitation_Minimum'];
$this->Precipitation_Maximum = $row['Precipitation_Maximum'];
$this->RootDepthMinimum = $row['RootDepthMinimum'];
$this->SalinityTolerance = $row['SalinityTolerance'];
$this->ShadeTolerance = $row['ShadeTolerance'];
$this->TemperatureMinimum = $row['TemperatureMinimum'];
$this->BloomPeriod = $row['BloomPeriod'];
$this->CommercialAvailability = $row['CommercialAvailability'];
$this->FruitSeedAbundance = $row['FruitSeedAbundance'];
$this->FruitSeedPeriodBegin = $row['FruitSeedPeriodBegin'];
$this->FruitSeedPeriodEnd = $row['FruitSeedPeriodEnd'];
$this->FruitSeedPersistence = $row['FruitSeedPersistence'];
$this->Propogated_by_BareRoot = $row['Propogated_by_BareRoot'];
$this->Propogated_by_Bulbs = $row['Propogated_by_Bulbs'];
$this->Propogated_by_Container = $row['Propogated_by_Container'];
$this->Propogated_by_Corms = $row['Propogated_by_Corms'];
$this->Propogated_by_Cuttings = $row['Propogated_by_Cuttings'];
$this->Propogated_by_Seed = $row['Propogated_by_Seed'];
$this->Propogated_by_Sod = $row['Propogated_by_Sod'];
$this->Propogated_by_Sprigs = $row['Propogated_by_Sprigs'];
$this->Propogated_by_Tubers = $row['Propogated_by_Tubers'];
$this->Seeds_per_Pound = $row['Seeds_per_Pound'];
$this->SeedSpreadRate = $row['SeedSpreadRate'];
$this->SeedlingVigor = $row['SeedlingVigor'];
$this->SmallGrain = $row['SmallGrain'];
$this->VegetativeSpreadRate = $row['VegetativeSpreadRate'];
$this->Berry_Nut_Seed_Product = $row['Berry_Nut_Seed_Product'];
$this->ChristmasTreeProduct = $row['ChristmasTreeProduct'];
$this->FodderProduct = $row['FodderProduct'];
$this->FuelwoodProduct = $row['FuelwoodProduct'];
$this->LumberProduct = $row['LumberProduct'];
$this->NavalStoreProduct = $row['NavalStoreProduct'];
$this->NurseryStockProduct = $row['NurseryStockProduct'];
$this->PalatableBrowseAnimal = $row['PalatableBrowseAnimal'];
$this->PalatableGrazeAnimal = $row['PalatableGrazeAnimal'];
$this->PalatableHuman = $row['PalatableHuman'];
$this->PostProduct = $row['PostProduct'];
$this->ProteinPotential = $row['ProteinPotential'];
$this->PulpwoodProduct = $row['PulpwoodProduct'];
$this->VeneerProduct = $row['VeneerProduct'];

}

}