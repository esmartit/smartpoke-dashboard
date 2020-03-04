<?php

  if (isset($configValues['FREERADIUS_VERSION']) && ($configValues['FREERADIUS_VERSION'] == '2')) {
    $row['postauth']['user'] = 'username';
    $row['postauth']['date'] = 'authdate';
  } elseif (isset($configValues['FREERADIUS_VERSION']) && ($configValues['FREERADIUS_VERSION'] == '1')) {
    $row['postauth']['user'] = 'user';
    $row['postauth']['date'] = 'date';
  }
