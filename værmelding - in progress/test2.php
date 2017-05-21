$yr = Yr\Yr::create("Norway/Vestfold/Sandefjord/Sandefjord", "/tmp");

$forecast = $yr->getCurrentForecast();
printf("Time: %s to %s\n", $forecast->getFrom()->format("H:i"), $forecast->getTo()->format("H:i"));
printf("Temp: %s %s\n", $forecast->getTemperature(), $forecast->getTemperature('unit'));
printf("Wind: %smps %s\n", $forecast->getWindSpeed(), $forecast->getWindDirection('name'));