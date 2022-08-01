<?php

namespace App\Core;

class Conf
{
    const debug = 1, online = 0,
        un = [
            '$2y$10$FsTGs/n8RsivRu3PZSMH3uZ2iAJVK9P.usasLdZ91dolVwOCNAofa',
            '$2y$10$nlccAFJqAThM1XZjBwRNCeOGrekkXsOoxgyaaN283q1SU8gnbXeua',
            '$2y$10$Fx0dy2FjRoqd6tAZsuU9teagPXiVGRCCSmyI6vhkoiFYLTFSpslqS',
            '$2y$10$fwFPUwd4At2Nxzf6yuAId.q.LExxHuD86M/hXJmNB1FT/2yhOHT4K',
            '$2y$10$cXL4ZOl.PdED9UEGphMzruuEYF2grTvO3PY9t/hXitqwKv0s0gKAC',
            '$2y$10$Xq/cuuE2Uvq4XhW1Wk1iYeXHD3EGCo9s1AC/xCXQ.Fd3nXOQNdFxe',
            '$2y$10$DjnqgAGydVbmvh4wkCw4I.5dGG.2v2ktaiD/jXgFbr3aM89aaNJ8S',
            '$2y$10$mvzbAkB8Yx1VhdRY2mQq9O81Q4TnLnTN8TiwzUOUWM9wln/DmXwJO',
            '$2y$10$Nk1XplnY8yoyjEEUDw8QtOlSoUbn.hqQAw2gPtbV1o42IgHWcW3Ru'
        ],
        pd = [
            '$2y$10$DYIVS7eQ4X6bGZrSDQrEZuOXf9JzDS3rx7e4Q8xU8nF4HWVJkuQqK',
            '$2y$10$xuJJRCEOY4o5KD0sOWW21.bNqlgjuRVkX8ph1BeUdqxZLhHcQyVxS',
            '$2y$10$3OouoECtnM430.oCEMXiGOYVRO6fCZ/ynLsfEYeGR00qrCsnoK08G',
            '$2y$10$k.q2e7mMnbk8hmqEjZ9nheGVmYTLIPgigtWb2O5N2Z4bUzLsUN1JS',
            '$2y$10$buLN957dODkVjK0/XQP7eu.ZgRzLTnqgWXiXgqAL4KQe/dwRH8L2.',
            '$2y$10$QEDUu8ISluNRLd6PGFVOX.KpIA4fA8NcZas6o8GGMzCd8hi4RzFPa',
            '$2y$10$LZKVImdtdCR0o1zkMGpzPuxzKPOw/uV7lKyw4CLDPCMjr9LRQHM.m',
            '$2y$10$UFsJriy20V4BH1S9Poq0geZEUsZ1MG/1cD11eKueQK4T6BXchmIfi',
            '$2y$10$V2gTuWcavz2QGNia5A0SouNB6QKVSL/GOvrSQfTtWKezG6IxuemfW'
        ], DEFAULT_MESSAGE = 'Erreur de connexion !';
    static $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        $db = [
            'hostname' => 'localhost',
            'dbname' => 'db_esge',
            'username' => 'root',
            'password' => ''
        ];
}
