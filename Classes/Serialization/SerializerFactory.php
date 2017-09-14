<?php

namespace DPN\SwConnect\Serialization;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\Extractor\SerializerExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializerFactory
{
    /**
     * @return Serializer
     */
    public static function createDefaultSerializer()
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $encoders = static::createExtractors();
        $propertyInfoExtractor = static::createPropertyExtractor($classMetadataFactory);

        $normalizers = [new DateTimeNormalizer(), new ArrayDenormalizer(), new ObjectNormalizer($classMetadataFactory, null, null, $propertyInfoExtractor)];

        return new Serializer($normalizers, $encoders);
    }

    public static function createPropertyExtractor(ClassMetadataFactory $classMetadataFactory)
    {
        // a full list of extractors is shown further below
        // $phpDocExtractor = new PhpDocExtractor();
        $reflectionExtractor = new ReflectionExtractor();
        $serializerExtractor = new SerializerExtractor($classMetadataFactory);

        // array of PropertyListExtractorInterface
        $listExtractors = [$serializerExtractor, $reflectionExtractor];

        // array of PropertyTypeExtractorInterface
        // $typeExtractors = array($phpDocExtractor, $reflectionExtractor);
        $typeExtractors = [$reflectionExtractor];

        // array of PropertyDescriptionExtractorInterface
        //$descriptionExtractors = array($phpDocExtractor);
        $descriptionExtractors = [];

        // array of PropertyAccessExtractorInterface
        $accessExtractors = [$reflectionExtractor];

        return new PropertyInfoExtractor(
            $listExtractors,
            $typeExtractors,
            $descriptionExtractors,
            $accessExtractors
        );
    }

    /**
     * @return array
     */
    protected static function createExtractors()
    {
        return [new XmlEncoder(), new JsonEncoder()];
    }
}
