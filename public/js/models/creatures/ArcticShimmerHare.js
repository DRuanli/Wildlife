// Arctic Shimmer Hare 3D Model using Three.js
// This file creates a 3D model of the Arctic Shimmer Hare at different growth stages
// Import this file and use the ArcticShimmerHare class in your project

import * as THREE from 'three';

class ArcticShimmerHare {
  constructor(stage = 'adult') {
    this.stage = stage; // 'egg', 'baby', 'juvenile', 'adult', or 'mythical'
    this.model = new THREE.Group();
    this.animations = {};
    this.createModel();
  }

  // Create the 3D model based on the current stage
  createModel() {
    this.model.clear();
    
    switch(this.stage) {
      case 'egg':
        this.createEgg();
        break;
      case 'baby':
        this.createBaby();
        break;
      case 'juvenile':
        this.createJuvenile();
        break;
      case 'adult':
        this.createAdult();
        break;
      case 'mythical':
        this.createMythical();
        break;
      default:
        this.createAdult();
    }
    
    // Add frost effect particles based on stage
    this.addFrostEffect();
    
    return this.model;
  }
  
  // Egg stage model
  createEgg() {
    // Create crystalline egg geometry
    const eggGeometry = new THREE.SphereGeometry(5, 32, 32);
    eggGeometry.scale(1, 1.5, 1);
    
    // Create frost pattern material with blue-white gradient
    const eggMaterial = new THREE.MeshPhysicalMaterial({
      color: 0xd8f0ff,
      transparent: true,
      opacity: 0.8,
      roughness: 0.2,
      metalness: 0.1,
      clearcoat: 1.0,
      clearcoatRoughness: 0.1,
      envMapIntensity: 1.0
    });
    
    const egg = new THREE.Mesh(eggGeometry, eggMaterial);
    
    // Add frost pattern displacement
    const frostPatternTexture = this.createFrostPatternTexture();
    eggMaterial.bumpMap = frostPatternTexture;
    eggMaterial.bumpScale = 0.2;
    
    this.model.add(egg);
    
    // Add egg animations
    this.addEggAnimations();
  }
  
  // Baby stage model
  createBaby() {
    // Create body
    const bodyGeometry = new THREE.SphereGeometry(3, 32, 16);
    bodyGeometry.scale(1, 0.8, 1.2);
    const bodyMaterial = new THREE.MeshStandardMaterial({
      color: 0xf0f8ff,
      roughness: 0.8,
      metalness: 0.1,
    });
    const body = new THREE.Mesh(bodyGeometry, bodyMaterial);
    
    // Create head
    const headGeometry = new THREE.SphereGeometry(2, 32, 16);
    const headMaterial = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      roughness: 0.7,
      metalness: 0.1,
    });
    const head = new THREE.Mesh(headGeometry, headMaterial);
    head.position.set(0, 0.5, 2.5);
    
    // Create ears
    const earGeometry = new THREE.ConeGeometry(0.7, 2, 16);
    const earMaterial = new THREE.MeshStandardMaterial({
      color: 0xf0f8ff,
      roughness: 0.7,
      metalness: 0.1,
    });
    
    const leftEar = new THREE.Mesh(earGeometry, earMaterial);
    leftEar.position.set(-1, 1.8, 2.5);
    leftEar.rotation.x = -Math.PI/6;
    leftEar.rotation.z = -Math.PI/8;
    
    const rightEar = new THREE.Mesh(earGeometry, earMaterial);
    rightEar.position.set(1, 1.8, 2.5);
    rightEar.rotation.x = -Math.PI/6;
    rightEar.rotation.z = Math.PI/8;
    
    // Create legs
    const legGeometry = new THREE.CylinderGeometry(0.5, 0.5, 2, 16);
    const legMaterial = new THREE.MeshStandardMaterial({
      color: 0xf0f8ff,
      roughness: 0.8,
      metalness: 0.1,
    });
    
    const frontLeftLeg = new THREE.Mesh(legGeometry, legMaterial);
    frontLeftLeg.position.set(-1.5, -2, 1.5);
    frontLeftLeg.rotation.x = Math.PI/6;
    
    const frontRightLeg = new THREE.Mesh(legGeometry, legMaterial);
    frontRightLeg.position.set(1.5, -2, 1.5);
    frontRightLeg.rotation.x = Math.PI/6;
    
    const backLeftLeg = new THREE.Mesh(legGeometry, legMaterial);
    backLeftLeg.position.set(-1.5, -2, -1.5);
    backLeftLeg.rotation.x = -Math.PI/6;
    
    const backRightLeg = new THREE.Mesh(legGeometry, legMaterial);
    backRightLeg.position.set(1.5, -2, -1.5);
    backRightLeg.rotation.x = -Math.PI/6;
    
    // Create tail
    const tailGeometry = new THREE.SphereGeometry(1, 16, 16);
    tailGeometry.scale(0.8, 0.8, 0.8);
    const tailMaterial = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      roughness: 0.7,
      metalness: 0.1,
    });
    const tail = new THREE.Mesh(tailGeometry, tailMaterial);
    tail.position.set(0, 0, -2.5);
    
    // Create eyes
    const eyeGeometry = new THREE.SphereGeometry(0.3, 16, 16);
    const eyeMaterial = new THREE.MeshStandardMaterial({
      color: 0x000000,
      roughness: 0.5,
      metalness: 0.1,
    });
    
    const leftEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
    leftEye.position.set(-0.8, 0.7, 4);
    
    const rightEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
    rightEye.position.set(0.8, 0.7, 4);
    
    // Add blue shimmering markings
    const markingsGeometry = new THREE.SphereGeometry(0.5, 16, 16);
    markingsGeometry.scale(2, 0.2, 0.5);
    const markingsMaterial = new THREE.MeshStandardMaterial({
      color: 0xa0d8ef,
      roughness: 0.5,
      metalness: 0.3,
      emissive: 0x3090c7,
      emissiveIntensity: 0.2
    });
    
    const backMarking = new THREE.Mesh(markingsGeometry, markingsMaterial);
    backMarking.position.set(0, 1, -1);
    backMarking.rotation.y = Math.PI/4;
    
    // Add all parts to the model
    this.model.add(body, head, leftEar, rightEar, 
                   frontLeftLeg, frontRightLeg, backLeftLeg, backRightLeg,
                   tail, leftEye, rightEye, backMarking);
    
    // Scale the entire model to baby size
    this.model.scale.set(0.6, 0.6, 0.6);
    
    // Add animation
    this.addBabyAnimations();
  }
  
  // Juvenile stage model
  createJuvenile() {
    // Create body
    const bodyGeometry = new THREE.SphereGeometry(4, 32, 16);
    bodyGeometry.scale(1, 0.8, 1.4);
    const bodyMaterial = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      roughness: 0.8,
      metalness: 0.1,
    });
    const body = new THREE.Mesh(bodyGeometry, bodyMaterial);
    
    // Create head
    const headGeometry = new THREE.SphereGeometry(2.5, 32, 16);
    const headMaterial = new THREE.MeshStandardMaterial({
      color: 0xf8f8ff,
      roughness: 0.7,
      metalness: 0.1,
    });
    const head = new THREE.Mesh(headGeometry, headMaterial);
    head.position.set(0, 1, 3.5);
    
    // Create ears with crystalline tips
    const earGeometry = new THREE.ConeGeometry(0.8, 3, 16);
    const earMaterial = new THREE.MeshStandardMaterial({
      color: 0xf0f8ff,
      roughness: 0.7,
      metalness: 0.1,
    });
    
    const leftEar = new THREE.Mesh(earGeometry, earMaterial);
    leftEar.position.set(-1.2, 2.5, 3.5);
    leftEar.rotation.x = -Math.PI/6;
    leftEar.rotation.z = -Math.PI/10;
    
    const rightEar = new THREE.Mesh(earGeometry, earMaterial);
    rightEar.position.set(1.2, 2.5, 3.5);
    rightEar.rotation.x = -Math.PI/6;
    rightEar.rotation.z = Math.PI/10;
    
    // Create crystalline ear tips
    const tipGeometry = new THREE.ConeGeometry(0.4, 1, 16);
    const tipMaterial = new THREE.MeshPhysicalMaterial({
      color: 0xadd8e6,
      roughness: 0.2,
      metalness: 0.8,
      transparent: true,
      opacity: 0.8,
      clearcoat: 1.0,
      clearcoatRoughness: 0.1,
      emissive: 0x3090c7,
      emissiveIntensity: 0.3
    });
    
    const leftTip = new THREE.Mesh(tipGeometry, tipMaterial);
    leftTip.position.set(-1.2, 4, 3);
    leftTip.rotation.x = -Math.PI/6;
    leftTip.rotation.z = -Math.PI/10;
    
    const rightTip = new THREE.Mesh(tipGeometry, tipMaterial);
    rightTip.position.set(1.2, 4, 3);
    rightTip.rotation.x = -Math.PI/6;
    rightTip.rotation.z = Math.PI/10;
    
    // Create legs
    const legGeometry = new THREE.CylinderGeometry(0.7, 0.7, 3, 16);
    const legMaterial = new THREE.MeshStandardMaterial({
      color: 0xf0f8ff,
      roughness: 0.8,
      metalness: 0.1,
    });
    
    const frontLeftLeg = new THREE.Mesh(legGeometry, legMaterial);
    frontLeftLeg.position.set(-2, -2.5, 2);
    frontLeftLeg.rotation.x = Math.PI/6;
    
    const frontRightLeg = new THREE.Mesh(legGeometry, legMaterial);
    frontRightLeg.position.set(2, -2.5, 2);
    frontRightLeg.rotation.x = Math.PI/6;
    
    const backLeftLeg = new THREE.Mesh(legGeometry, legMaterial);
    backLeftLeg.position.set(-2, -2.5, -2);
    backLeftLeg.rotation.x = -Math.PI/6;
    
    const backRightLeg = new THREE.Mesh(legGeometry, legMaterial);
    backRightLeg.position.set(2, -2.5, -2);
    backRightLeg.rotation.x = -Math.PI/6;
    
    // Create tail
    const tailGeometry = new THREE.SphereGeometry(1.2, 16, 16);
    tailGeometry.scale(1, 1, 1);
    const tailMaterial = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      roughness: 0.7,
      metalness: 0.1,
    });
    const tail = new THREE.Mesh(tailGeometry, tailMaterial);
    tail.position.set(0, 0, -3.5);
    
    // Create eyes
    const eyeGeometry = new THREE.SphereGeometry(0.4, 16, 16);
    const eyeMaterial = new THREE.MeshStandardMaterial({
      color: 0x000000,
      roughness: 0.5,
      metalness: 0.1,
    });
    
    const leftEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
    leftEye.position.set(-1, 1.2, 5.5);
    
    const rightEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
    rightEye.position.set(1, 1.2, 5.5);
    
    // Add blue-silver markings with more definition
    const markingsGeometry = new THREE.SphereGeometry(1, 16, 16);
    markingsGeometry.scale(2, 0.2, 1);
    const markingsMaterial = new THREE.MeshStandardMaterial({
      color: 0xa0d8ef,
      roughness: 0.5,
      metalness: 0.4,
      emissive: 0x3090c7,
      emissiveIntensity: 0.3
    });
    
    const backMarking = new THREE.Mesh(markingsGeometry, markingsMaterial);
    backMarking.position.set(0, 1.2, -1);
    
    const sideMarking1 = new THREE.Mesh(markingsGeometry, markingsMaterial);
    sideMarking1.position.set(2.5, 0.5, 0);
    sideMarking1.rotation.z = Math.PI/2;
    sideMarking1.rotation.y = Math.PI/2;
    sideMarking1.scale.set(0.5, 0.5, 0.5);
    
    const sideMarking2 = new THREE.Mesh(markingsGeometry, markingsMaterial);
    sideMarking2.position.set(-2.5, 0.5, 0);
    sideMarking2.rotation.z = Math.PI/2;
    sideMarking2.rotation.y = Math.PI/2;
    sideMarking2.scale.set(0.5, 0.5, 0.5);
    
    // Add all parts to the model
    this.model.add(body, head, leftEar, rightEar, leftTip, rightTip,
                   frontLeftLeg, frontRightLeg, backLeftLeg, backRightLeg,
                   tail, leftEye, rightEye, backMarking, sideMarking1, sideMarking2);
    
    // Scale the entire model to juvenile size
    this.model.scale.set(0.8, 0.8, 0.8);
    
    // Add animation
    this.addJuvenileAnimations();
  }
  
  // Adult stage model
  createAdult() {
    // Create body
    const bodyGeometry = new THREE.SphereGeometry(5, 32, 16);
    bodyGeometry.scale(1, 0.8, 1.5);
    const bodyMaterial = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      roughness: 0.8,
      metalness: 0.1,
    });
    const body = new THREE.Mesh(bodyGeometry, bodyMaterial);
    
    // Create head
    const headGeometry = new THREE.SphereGeometry(3, 32, 16);
    const headMaterial = new THREE.MeshStandardMaterial({
      color: 0xf8f8ff,
      roughness: 0.7,
      metalness: 0.1,
    });
    const head = new THREE.Mesh(headGeometry, headMaterial);
    head.position.set(0, 1.5, 4.5);
    
    // Create ears with fully developed crystalline tips
    const earGeometry = new THREE.ConeGeometry(1, 3.5, 16);
    const earMaterial = new THREE.MeshStandardMaterial({
      color: 0xf0f8ff,
      roughness: 0.7,
      metalness: 0.1,
    });
    
    const leftEar = new THREE.Mesh(earGeometry, earMaterial);
    leftEar.position.set(-1.5, 3, 4.5);
    leftEar.rotation.x = -Math.PI/6;
    leftEar.rotation.z = -Math.PI/12;
    
    const rightEar = new THREE.Mesh(earGeometry, earMaterial);
    rightEar.position.set(1.5, 3, 4.5);
    rightEar.rotation.x = -Math.PI/6;
    rightEar.rotation.z = Math.PI/12;
    
    // Create crystalline ear tips
    const tipGeometry = new THREE.ConeGeometry(0.6, 1.5, 16);
    const tipMaterial = new THREE.MeshPhysicalMaterial({
      color: 0x89cff0,
      roughness: 0.2,
      metalness: 0.8,
      transparent: true,
      opacity: 0.8,
      clearcoat: 1.0,
      clearcoatRoughness: 0.1,
      emissive: 0x3090c7,
      emissiveIntensity: 0.4
    });
    
    const leftTip = new THREE.Mesh(tipGeometry, tipMaterial);
    leftTip.position.set(-1.5, 5, 4);
    leftTip.rotation.x = -Math.PI/6;
    leftTip.rotation.z = -Math.PI/12;
    
    const rightTip = new THREE.Mesh(tipGeometry, tipMaterial);
    rightTip.position.set(1.5, 5, 4);
    rightTip.rotation.x = -Math.PI/6;
    rightTip.rotation.z = Math.PI/12;
    
    // Create legs with larger feet
    const legGeometry = new THREE.CylinderGeometry(0.8, 0.8, 3.5, 16);
    const legMaterial = new THREE.MeshStandardMaterial({
      color: 0xf0f8ff,
      roughness: 0.8,
      metalness: 0.1,
    });
    
    const frontLeftLeg = new THREE.Mesh(legGeometry, legMaterial);
    frontLeftLeg.position.set(-2.5, -2.5, 3);
    frontLeftLeg.rotation.x = Math.PI/6;
    
    const frontRightLeg = new THREE.Mesh(legGeometry, legMaterial);
    frontRightLeg.position.set(2.5, -2.5, 3);
    frontRightLeg.rotation.x = Math.PI/6;
    
    const backLeftLeg = new THREE.Mesh(legGeometry, legMaterial);
    backLeftLeg.position.set(-2.5, -2.5, -2.5);
    backLeftLeg.rotation.x = -Math.PI/6;
    
    const backRightLeg = new THREE.Mesh(legGeometry, legMaterial);
    backRightLeg.position.set(2.5, -2.5, -2.5);
    backRightLeg.rotation.x = -Math.PI/6;
    
    // Create feet
    const footGeometry = new THREE.SphereGeometry(1, 16, 16);
    footGeometry.scale(1.2, 0.6, 1.5);
    const footMaterial = new THREE.MeshStandardMaterial({
      color: 0xf0f8ff,
      roughness: 0.8,
      metalness: 0.1,
    });
    
    const frontLeftFoot = new THREE.Mesh(footGeometry, footMaterial);
    frontLeftFoot.position.set(-2.5, -4, 4);
    
    const frontRightFoot = new THREE.Mesh(footGeometry, footMaterial);
    frontRightFoot.position.set(2.5, -4, 4);
    
    const backLeftFoot = new THREE.Mesh(footGeometry, footMaterial);
    backLeftFoot.position.set(-2.5, -4, -4);
    
    const backRightFoot = new THREE.Mesh(footGeometry, footMaterial);
    backRightFoot.position.set(2.5, -4, -4);
    
    // Create tail
    const tailGeometry = new THREE.SphereGeometry(1.5, 16, 16);
    const tailMaterial = new THREE.MeshStandardMaterial({
      color: 0xffffff,
      roughness: 0.7,
      metalness: 0.1,
    });
    const tail = new THREE.Mesh(tailGeometry, tailMaterial);
    tail.position.set(0, 0, -5);
    
    // Create eyes
    const eyeGeometry = new THREE.SphereGeometry(0.5, 16, 16);
    const eyeMaterial = new THREE.MeshStandardMaterial({
      color: 0x000000,
      roughness: 0.5,
      metalness: 0.1,
    });
    
    const leftEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
    leftEye.position.set(-1.2, 2, 7);
    
    const rightEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
    rightEye.position.set(1.2, 2, 7);
    
    // Add striking blue-silver fur patterns
    const createPattern = (x, y, z, rotationY, scale = 1) => {
      const patternGeometry = new THREE.SphereGeometry(1, 16, 16);
      patternGeometry.scale(2 * scale, 0.2 * scale, 1 * scale);
      const patternMaterial = new THREE.MeshStandardMaterial({
        color: 0x89cff0,
        roughness: 0.5,
        metalness: 0.5,
        emissive: 0x3090c7,
        emissiveIntensity: 0.4
      });
      
      const pattern = new THREE.Mesh(patternGeometry, patternMaterial);
      pattern.position.set(x, y, z);
      pattern.rotation.y = rotationY;
      return pattern;
    };
    
    const patterns = [
      createPattern(0, 1.5, -2, 0, 1.2),
      createPattern(3, 1, 0, Math.PI/2, 1),
      createPattern(-3, 1, 0, Math.PI/2, 1),
      createPattern(0, 1.5, 2, Math.PI/4, 0.8),
      createPattern(2, 0, -4, Math.PI/3, 0.7),
      createPattern(-2, 0, -4, -Math.PI/3, 0.7)
    ];
    
    // Add all parts to the model
    this.model.add(body, head, leftEar, rightEar, leftTip, rightTip,
                   frontLeftLeg, frontRightLeg, backLeftLeg, backRightLeg,
                   frontLeftFoot, frontRightFoot, backLeftFoot, backRightFoot,
                   tail, leftEye, rightEye, ...patterns);
    
    // Add animation
    this.addAdultAnimations();
  }
  
  // Mythical stage model
  createMythical() {
    // Create body with glowing patterns
    const bodyGeometry = new THREE.SphereGeometry(6, 32, 16);
    bodyGeometry.scale(1, 0.8, 1.6);
    const bodyMaterial = new THREE.MeshPhysicalMaterial({
      color: 0xf0f8ff,
      roughness: 0.6,
      metalness: 0.2,
      clearcoat: 0.4,
      clearcoatRoughness: 0.2,
    });
    const body = new THREE.Mesh(bodyGeometry, bodyMaterial);
    
    // Create head
    const headGeometry = new THREE.SphereGeometry(3.5, 32, 16);
    const headMaterial = new THREE.MeshPhysicalMaterial({
      color: 0xf8f8ff,
      roughness: 0.6,
      metalness: 0.2,
      clearcoat: 0.4,
      clearcoatRoughness: 0.2,
    });
    const head = new THREE.Mesh(headGeometry, headMaterial);
    head.position.set(0, 2, 5.5);
    
    // Create magical crystalline ears
    const earGeometry = new THREE.ConeGeometry(1.2, 4, 16);
    const earMaterial = new THREE.MeshPhysicalMaterial({
      color: 0xf0f8ff,
      roughness: 0.6,
      metalness: 0.3,
      clearcoat: 0.4,
      clearcoatRoughness: 0.2,
    });
    
    const leftEar = new THREE.Mesh(earGeometry, earMaterial);
    leftEar.position.set(-1.8, 4, 5.5);
    leftEar.rotation.x = -Math.PI/6;
    leftEar.rotation.z = -Math.PI/12;
    
    const rightEar = new THREE.Mesh(earGeometry, earMaterial);
    rightEar.position.set(1.8, 4, 5.5);
    rightEar.rotation.x = -Math.PI/6;
    rightEar.rotation.z = Math.PI/12;
    
    // Create glowing crystalline ear tips
    const tipGeometry = new THREE.ConeGeometry(0.8, 2, 16);
    const tipMaterial = new THREE.MeshPhysicalMaterial({
      color: 0x00bfff,
      roughness: 0.1,
      metalness: 0.9,
      transparent: true,
      opacity: 0.9,
      clearcoat: 1.0,
      clearcoatRoughness: 0.1,
      emissive: 0x007fff,
      emissiveIntensity: 0.8
    });
    
    const leftTip = new THREE.Mesh(tipGeometry, tipMaterial);
    leftTip.position.set(-1.8, 6.5, 5);
    leftTip.rotation.x = -Math.PI/6;
    leftTip.rotation.z = -Math.PI/12;
    
    const rightTip = new THREE.Mesh(tipGeometry, tipMaterial);
    rightTip.position.set(1.8, 6.5, 5);
    rightTip.rotation.x = -Math.PI/6;
    rightTip.rotation.z = Math.PI/12;
    
    // Create legs
    const legGeometry = new THREE.CylinderGeometry(1, 1, 4, 16);
    const legMaterial = new THREE.MeshPhysicalMaterial({
      color: 0xf0f8ff,
      roughness: 0.6,
      metalness: 0.2,
      clearcoat: 0.4,
      clearcoatRoughness: 0.2,
    });
    
    const frontLeftLeg = new THREE.Mesh(legGeometry, legMaterial);
    frontLeftLeg.position.set(-3, -3, 3.5);
    frontLeftLeg.rotation.x = Math.PI/6;
    
    const frontRightLeg = new THREE.Mesh(legGeometry, legMaterial);
    frontRightLeg.position.set(3, -3, 3.5);
    frontRightLeg.rotation.x = Math.PI/6;
    
    const backLeftLeg = new THREE.Mesh(legGeometry, legMaterial);
    backLeftLeg.position.set(-3, -3, -3);
    backLeftLeg.rotation.x = -Math.PI/6;
    
    const backRightLeg = new THREE.Mesh(legGeometry, legMaterial);
    backRightLeg.position.set(3, -3, -3);
    backRightLeg.rotation.x = -Math.PI/6;
    
    // Create glowing feet that leave frost patterns
    const footGeometry = new THREE.SphereGeometry(1.5, 16, 16);
    footGeometry.scale(1.2, 0.6, 1.5);
    const footMaterial = new THREE.MeshPhysicalMaterial({
      color: 0xf0f8ff,
      roughness: 0.5,
      metalness: 0.3,
      emissive: 0xb0e2ff,
      emissiveIntensity: 0.3,
      clearcoat: 0.5,
      clearcoatRoughness: 0.2,
    });
    
    const frontLeftFoot = new THREE.Mesh(footGeometry, footMaterial);
    frontLeftFoot.position.set(-3, -5, 4.5);
    
    const frontRightFoot = new THREE.Mesh(footGeometry, footMaterial);
    frontRightFoot.position.set(3, -5, 4.5);
    
    const backLeftFoot = new THREE.Mesh(footGeometry, footMaterial);
    backLeftFoot.position.set(-3, -5, -4.5);
    
    const backRightFoot = new THREE.Mesh(footGeometry, footMaterial);
    backRightFoot.position.set(3, -5, -4.5);
    
    // Create tail
    const tailGeometry = new THREE.SphereGeometry(2, 16, 16);
    const tailMaterial = new THREE.MeshPhysicalMaterial({
      color: 0xffffff,
      roughness: 0.6,
      metalness: 0.2,
      clearcoat: 0.4,
      clearcoatRoughness: 0.2,
    });
    const tail = new THREE.Mesh(tailGeometry, tailMaterial);
    tail.position.set(0, 0, -6);
    
    // Create glowing eyes
    const eyeGeometry = new THREE.SphereGeometry(0.6, 16, 16);
    const eyeMaterial = new THREE.MeshStandardMaterial({
      color: 0x000000,
      roughness: 0.5,
      metalness: 0.1,
    });
    
    const leftEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
    leftEye.position.set(-1.5, 2.5, 8);
    
    const rightEye = new THREE.Mesh(eyeGeometry, eyeMaterial);
    rightEye.position.set(1.5, 2.5, 8);
    
    // Create glowing pupil
    const pupilGeometry = new THREE.SphereGeometry(0.2, 16, 16);
    const pupilMaterial = new THREE.MeshStandardMaterial({
      color: 0x007fff,
      emissive: 0x007fff,
      emissiveIntensity: 1.0
    });
    
    const leftPupil = new THREE.Mesh(pupilGeometry, pupilMaterial);
    leftPupil.position.set(-1.5, 2.5, 8.5);
    
    const rightPupil = new THREE.Mesh(pupilGeometry, pupilMaterial);
    rightPupil.position.set(1.5, 2.5, 8.5);
    
    // Add ethereal frost patterns
    const createPattern = (x, y, z, rotationY, scale = 1) => {
      const patternGeometry = new THREE.SphereGeometry(1, 16, 16);
      patternGeometry.scale(2 * scale, 0.2 * scale, 1 * scale);
      const patternMaterial = new THREE.MeshPhysicalMaterial({
        color: 0x00bfff,
        roughness: 0.3,
        metalness: 0.7,
        transparent: true,
        opacity: 0.9,
        emissive: 0x007fff,
        emissiveIntensity: 0.7,
        clearcoat: 1.0,
        clearcoatRoughness: 0.1,
      });
      
      const pattern = new THREE.Mesh(patternGeometry, patternMaterial);
      pattern.position.set(x, y, z);
      pattern.rotation.y = rotationY;
      return pattern;
    };
    
    const patterns = [
      createPattern(0, 2, -3, 0, 1.5),
      createPattern(4, 1.5, 0, Math.PI/2, 1.2),
      createPattern(-4, 1.5, 0, Math.PI/2, 1.2),
      createPattern(0, 2, 3, Math.PI/4, 1),
      createPattern(2.5, 0.5, -5, Math.PI/3, 0.9),
      createPattern(-2.5, 0.5, -5, -Math.PI/3, 0.9),
      createPattern(0, 3, 0, Math.PI/6, 1.8)
    ];
    
    // Add all parts to the model
    this.model.add(body, head, leftEar, rightEar, leftTip, rightTip,
                   frontLeftLeg, frontRightLeg, backLeftLeg, backRightLeg,
                   frontLeftFoot, frontRightFoot, backLeftFoot, backRightFoot,
                   tail, leftEye, rightEye, leftPupil, rightPupil, ...patterns);
    
    // Add mythical animation
    this.addMythicalAnimations();
  }
  
  // Add frost effect particles
  addFrostEffect() {
    // Scale particle effect based on stage
    let particleCount = 0;
    let particleSize = 0;
    let emissionRate = 0;
    
    switch(this.stage) {
      case 'egg':
        particleCount = 20;
        particleSize = 0.1;
        emissionRate = 0.01;
        break;
      case 'baby':
        particleCount = 30;
        particleSize = 0.15;
        emissionRate = 0.02;
        break;
      case 'juvenile':
        particleCount = 40;
        particleSize = 0.2;
        emissionRate = 0.03;
        break;
      case 'adult':
        particleCount = 50;
        particleSize = 0.25;
        emissionRate = 0.04;
        break;
      case 'mythical':
        particleCount = 80;
        particleSize = 0.3;
        emissionRate = 0.06;
        break;
    }
    
    // Create frost particles
    const particlesGeometry = new THREE.BufferGeometry();
    const particlesMaterial = new THREE.PointsMaterial({
      color: 0xadd8e6,
      size: particleSize,
      transparent: true,
      opacity: 0.7,
      blending: THREE.AdditiveBlending,
      sizeAttenuation: true,
    });
    
    const positions = new Float32Array(particleCount * 3);
    const velocities = [];
    
    for (let i = 0; i < particleCount; i++) {
      // Random position around the creature
      const radius = 8;
      const theta = Math.random() * Math.PI * 2;
      const phi = Math.random() * Math.PI;
      
      positions[i * 3] = radius * Math.sin(phi) * Math.cos(theta);
      positions[i * 3 + 1] = radius * Math.sin(phi) * Math.sin(theta);
      positions[i * 3 + 2] = radius * Math.cos(phi);
      
      // Random velocity
      velocities.push({
        x: (Math.random() - 0.5) * emissionRate,
        y: (Math.random() - 0.5) * emissionRate,
        z: (Math.random() - 0.5) * emissionRate
      });
    }
    
    particlesGeometry.setAttribute('position', new THREE.BufferAttribute(positions, 3));
    
    const particles = new THREE.Points(particlesGeometry, particlesMaterial);
    this.model.add(particles);
    
    // Animation function for particles
    const animateParticles = () => {
      const positions = particles.geometry.attributes.position.array;
      
      for (let i = 0; i < particleCount; i++) {
        // Update position based on velocity
        positions[i * 3] += velocities[i].x;
        positions[i * 3 + 1] += velocities[i].y;
        positions[i * 3 + 2] += velocities[i].z;
        
        // If particle gets too far, reset it
        const distance = Math.sqrt(
          positions[i * 3] ** 2 + 
          positions[i * 3 + 1] ** 2 + 
          positions[i * 3 + 2] ** 2
        );
        
        if (distance > 10) {
          // Reset position
          const radius = 8;
          const theta = Math.random() * Math.PI * 2;
          const phi = Math.random() * Math.PI;
          
          positions[i * 3] = radius * Math.sin(phi) * Math.cos(theta);
          positions[i * 3 + 1] = radius * Math.sin(phi) * Math.sin(theta);
          positions[i * 3 + 2] = radius * Math.cos(phi);
          
          // Reset velocity
          velocities[i] = {
            x: (Math.random() - 0.5) * emissionRate,
            y: (Math.random() - 0.5) * emissionRate,
            z: (Math.random() - 0.5) * emissionRate
          };
        }
      }
      
      particles.geometry.attributes.position.needsUpdate = true;
      requestAnimationFrame(animateParticles);
    };
    
    animateParticles();
  }
  
  // Create frost pattern texture
  createFrostPatternTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 512;
    canvas.height = 512;
    const context = canvas.getContext('2d');
    
    // Fill with light blue background
    context.fillStyle = '#f0f8ff';
    context.fillRect(0, 0, canvas.width, canvas.height);
    
    // Draw frost pattern
    const drawFractal = (x, y, size, angle, depth) => {
      if (depth <= 0) return;
      
      const length = size * 0.7;
      
      context.strokeStyle = '#add8e6';
      context.lineWidth = depth;
      context.beginPath();
      context.moveTo(x, y);
      
      const endX = x + length * Math.cos(angle);
      const endY = y + length * Math.sin(angle);
      
      context.lineTo(endX, endY);
      context.stroke();
      
      // Draw branches
      const branchAngle = Math.PI / 4; // 45 degrees
      drawFractal(endX, endY, size * 0.5, angle + branchAngle, depth - 1);
      drawFractal(endX, endY, size * 0.5, angle - branchAngle, depth - 1);
    };
    
    // Draw multiple frost patterns
    for (let i = 0; i < 6; i++) {
      const x = Math.random() * canvas.width;
      const y = Math.random() * canvas.height;
      const size = 40 + Math.random() * 30;
      const angle = Math.random() * Math.PI * 2;
      drawFractal(x, y, size, angle, 3);
    }
    
    const texture = new THREE.CanvasTexture(canvas);
    return texture;
  }
  
  // Animation methods for each stage
  addEggAnimations() {
    // Simple pulsing animation for the egg
    const egg = this.model.children[0];
    
    const pulseAnimation = () => {
      const time = Date.now() * 0.001; // Convert to seconds
      
      // Subtle scale pulsing
      const scale = 1 + Math.sin(time * 0.5) * 0.03;
      egg.scale.set(scale, scale, scale);
      
      // Subtle rotation
      egg.rotation.y = time * 0.1;
      
      requestAnimationFrame(pulseAnimation);
    };
    
    pulseAnimation();
    this.animations.pulse = pulseAnimation;
  }
  
  addBabyAnimations() {
    // Cute hopping animation for baby hare
    const animateHopping = () => {
      const time = Date.now() * 0.001; // Convert to seconds
      
      // Bobbing up and down
      this.model.position.y = Math.sin(time * 2) * 0.3;
      
      // Slight rotation
      this.model.rotation.x = Math.sin(time * 2) * 0.05;
      this.model.rotation.z = Math.sin(time * 1.5) * 0.05;
      
      requestAnimationFrame(animateHopping);
    };
    
    animateHopping();
    this.animations.hopping = animateHopping;
  }
  
  addJuvenileAnimations() {
    // More energetic movement
    const animateJuvenile = () => {
      const time = Date.now() * 0.001; // Convert to seconds
      
      // More pronounced bobbing
      this.model.position.y = Math.sin(time * 2.5) * 0.5;
      
      // Occasional left-right movement
      this.model.position.x = Math.sin(time * 0.8) * 0.3;
      
      // Slight rotation
      this.model.rotation.x = Math.sin(time * 2) * 0.08;
      this.model.rotation.z = Math.sin(time * 1.8) * 0.08;
      
      // Make ear tips glow periodically
      const leftTip = this.model.children[4];
      const rightTip = this.model.children[5];
      
      if (leftTip && rightTip) {
        const glowIntensity = 0.3 + Math.sin(time * 3) * 0.2;
        leftTip.material.emissiveIntensity = glowIntensity;
        rightTip.material.emissiveIntensity = glowIntensity;
      }
      
      requestAnimationFrame(animateJuvenile);
    };
    
    animateJuvenile();
    this.animations.juvenile = animateJuvenile;
  }
  
  addAdultAnimations() {
    // Graceful, confident movement
    const animateAdult = () => {
      const time = Date.now() * 0.001; // Convert to seconds
      
      // Smoother, more subtle movement
      this.model.position.y = Math.sin(time * 1.5) * 0.3;
      this.model.position.x = Math.sin(time * 0.6) * 0.2;
      this.model.position.z = Math.sin(time * 0.4) * 0.2;
      
      // Very slight rotation for balance
      this.model.rotation.x = Math.sin(time * 1.2) * 0.05;
      this.model.rotation.z = Math.sin(time * 1) * 0.05;
      
      // Make ear tips glow with a pattern
      const leftTip = this.model.children[4];
      const rightTip = this.model.children[5];
      
      if (leftTip && rightTip) {
        const glowIntensity = 0.4 + Math.sin(time * 2) * 0.2;
        leftTip.material.emissiveIntensity = glowIntensity;
        rightTip.material.emissiveIntensity = glowIntensity;
      }
      
      // Animate the blue markings
      const patterns = this.model.children.slice(16);
      patterns.forEach((pattern, index) => {
        pattern.material.emissiveIntensity = 0.4 + Math.sin(time * 1.5 + index * 0.2) * 0.2;
      });
      
      requestAnimationFrame(animateAdult);
    };
    
    animateAdult();
    this.animations.adult = animateAdult;
  }
  
  addMythicalAnimations() {
    // Magical, ethereal movement
    const animateMythical = () => {
      const time = Date.now() * 0.001; // Convert to seconds
      
      // Floating movement that seems to defy gravity
      this.model.position.y = Math.sin(time * 0.8) * 0.7;
      this.model.position.x = Math.sin(time * 0.5) * 0.3;
      this.model.position.z = Math.sin(time * 0.3) * 0.3;
      
      // Slight ethereal rotation
      this.model.rotation.y = Math.sin(time * 0.2) * 0.1;
      this.model.rotation.x = Math.sin(time * 0.3) * 0.05;
      this.model.rotation.z = Math.sin(time * 0.4) * 0.05;
      
      // Animate the crystalline ear tips
      const leftTip = this.model.children[4];
      const rightTip = this.model.children[5];
      
      if (leftTip && rightTip) {
        const glowIntensity = 0.8 + Math.sin(time * 2.5) * 0.3;
        leftTip.material.emissiveIntensity = glowIntensity;
        rightTip.material.emissiveIntensity = glowIntensity;
      }
      
      // Animate the glowing feet
      const feet = [
        this.model.children[10], // frontLeftFoot
        this.model.children[11], // frontRightFoot
        this.model.children[12], // backLeftFoot
        this.model.children[13], // backRightFoot
      ];
      
      feet.forEach((foot, index) => {
        if (foot) {
          const footGlow = 0.3 + Math.sin(time * 2 + index * 0.5) * 0.2;
          foot.material.emissiveIntensity = footGlow;
        }
      });
      
      // Animate the glowing pupils
      const leftPupil = this.model.children[16];
      const rightPupil = this.model.children[17];
      
      if (leftPupil && rightPupil) {
        const pupilGlow = 1.0 + Math.sin(time * 3) * 0.3;
        leftPupil.material.emissiveIntensity = pupilGlow;
        rightPupil.material.emissiveIntensity = pupilGlow;
      }
      
      // Animate the frost patterns
      const patterns = this.model.children.slice(18);
      patterns.forEach((pattern, index) => {
        pattern.material.emissiveIntensity = 0.7 + Math.sin(time * 1.8 + index * 0.3) * 0.3;
        // Slight rotation of the patterns for a magical effect
        pattern.rotation.z = Math.sin(time * 0.3 + index * 0.1) * 0.05;
      });
      
      requestAnimationFrame(animateMythical);
    };
    
    animateMythical();
    this.animations.mythical = animateMythical;
  }
  
  // Set the stage of the creature
  setStage(stage) {
    if (['egg', 'baby', 'juvenile', 'adult', 'mythical'].includes(stage)) {
      this.stage = stage;
      this.createModel();
    }
  }
  
  // Get the 3D model
  getModel() {
    return this.model;
  }
  
  // Helper method to create a simple snowflake particle system
  createSnowflakeEffect(parent, count = 50, radius = 5) {
    const geometry = new THREE.BufferGeometry();
    const vertices = [];
    
    for (let i = 0; i < count; i++) {
      // Random position in a sphere
      const r = radius * Math.cbrt(Math.random());
      const theta = Math.random() * Math.PI * 2;
      const phi = Math.acos(2 * Math.random() - 1);
      
      const x = r * Math.sin(phi) * Math.cos(theta);
      const y = r * Math.sin(phi) * Math.sin(theta);
      const z = r * Math.cos(phi);
      
      vertices.push(x, y, z);
    }
    
    geometry.setAttribute('position', new THREE.Float32BufferAttribute(vertices, 3));
    
    // Create snowflake texture
    const snowflakeTexture = this.createSnowflakeTexture();
    
    const material = new THREE.PointsMaterial({
      size: 0.4,
      map: snowflakeTexture,
      transparent: true,
      opacity: 0.7,
      blending: THREE.AdditiveBlending,
      depthWrite: false,
    });
    
    const particles = new THREE.Points(geometry, material);
    parent.add(particles);
    
    return particles;
  }
  
  // Create a snowflake texture
  createSnowflakeTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 64;
    canvas.height = 64;
    const context = canvas.getContext('2d');
    
    // Clear canvas
    context.fillStyle = 'rgba(0,0,0,0)';
    context.fillRect(0, 0, canvas.width, canvas.height);
    
    // Draw snowflake
    context.strokeStyle = 'white';
    context.lineWidth = 2;
    const centerX = canvas.width / 2;
    const centerY = canvas.height / 2;
    const size = canvas.width / 3;
    
    // Draw snowflake arms
    for (let i = 0; i < 6; i++) {
      const angle = (Math.PI / 3) * i;
      context.beginPath();
      context.moveTo(centerX, centerY);
      context.lineTo(
        centerX + size * Math.cos(angle),
        centerY + size * Math.sin(angle)
      );
      context.stroke();
      
      // Draw branches on each arm
      const branchSize = size * 0.4;
      const branchX = centerX + (size * 0.6) * Math.cos(angle);
      const branchY = centerY + (size * 0.6) * Math.sin(angle);
      
      context.beginPath();
      context.moveTo(branchX, branchY);
      context.lineTo(
        branchX + branchSize * Math.cos(angle + Math.PI/4),
        branchY + branchSize * Math.sin(angle + Math.PI/4)
      );
      context.stroke();
      
      context.beginPath();
      context.moveTo(branchX, branchY);
      context.lineTo(
        branchX + branchSize * Math.cos(angle - Math.PI/4),
        branchY + branchSize * Math.sin(angle - Math.PI/4)
      );
      context.stroke();
    }
    
    // Create texture from canvas
    const texture = new THREE.CanvasTexture(canvas);
    return texture;
  }
  
  // Update method to call in animation loop
  update() {
    // This method would be called in the main animation loop
    // Our animations are self-contained with requestAnimationFrame
  }
  
  // Dispose method to clean up resources
  dispose() {
    // Stop animations
    for (const animationName in this.animations) {
      cancelAnimationFrame(this.animations[animationName]);
    }
    
    // Dispose geometries and materials
    this.model.traverse((object) => {
      if (object.geometry) {
        object.geometry.dispose();
      }
      
      if (object.material) {
        if (Array.isArray(object.material)) {
          object.material.forEach(material => material.dispose());
        } else {
          object.material.dispose();
        }
      }
    });
  }
}

export default ArcticShimmerHare;

// Usage example:
// Import Three.js and this file
// const scene = new THREE.Scene();
// const hare = new ArcticShimmerHare('mythical');
// scene.add(hare.getModel());
// 
// // To change stage:
// hare.setStage('baby');
//
// // In animation loop:
// function animate() {
//   requestAnimationFrame(animate);
//   renderer.render(scene, camera);
// }