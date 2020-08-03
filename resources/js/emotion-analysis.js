/*
 * This file is part of Emotionally.
 *
 * Emotionally is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Emotionally is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Emotionally.  If not, see <http://www.gnu.org/licenses/>.
 */

"use strict";

// $ = require('jquery');

/**
 * The interface to the emotion analysis's engine.
 */
class EmotionAnalysis {
    constructor() {
    }

    /**
     * A collection of possible face modes.
     * @typedef {number} FaceMode
     * @enum {number}
     * @readonly
     */
    static get FaceMode() {
        return {
            /** A value to be used if the video has large faces */
            LARGE_FACES: affdex.FaceDetectorMode.LARGE_FACES,
            /** A value to be used if the video has small faces */
            SMALL_FACES: affdex.FaceDetectorMode.SMALL_FACES
        };
    }

    /**
     * Create a new default configuration.
     * @typedef {Object} Configuration
     * @property {number} [start=0] Where to start (in seconds)
     * @property {number} [sec_step=0.1] The step size of extracting emotion (in
     * seconds).
     * @property {number} [stop=undefined] Where to stop (in seconds). If
     * undefined or less or equal to secs, the entire video will be analyzed.
     * @property {FaceMode} [faceMode=FaceMode.LARGE_FACES] The type of faces in the video.
     * @property {Object} detect
     * @property {boolean} detect.emotions Should it detect emotions?
     * @property {boolean} detect.expressions Should it detect expressions?
     * @property {boolean} detect.emojis Should it detect emojis?
     * @property {boolean} detect.appearance Should it detect appearance?
     * @return {Configuration} The default configuration
     */
    static getDefaultConfiguration() {
        return {
            start: 0,
            sec_step: 0.1,
            stop: undefined,
            faceMode: EmotionAnalysis.FaceMode.LARGE_FACES,
            detect: {
                emotions: true,
                expressions: true,
                emojis: true,
                appearance: true
            }
        };
    }

    /**
     * A callback to be used at the end of an analysis.
     * @callback AnalysisCompletedCallback
     * @param report {string} The generated report.
     */

    /**
     * Analyze a video.
     * @param {string} filename The path to the video file.
     * This is relative to the current location in the server.
     * @param {AnalysisCompletedCallback} [callback] A callback.
     * @param {Configuration} [options] The configuration of the analysis.
     */
    static analyzeVideo(filename, callback = undefined, options = undefined) {
        // Set verbose = true to print images and detection succes, false if you don't want info
        if (options === undefined) {
            options = EmotionAnalysis.getDefaultConfiguration();
        } else {
            options = _.assign({}, EmotionAnalysis.getDefaultConfiguration(), options);
        }

        const verbose = false;
        let secs = options.start;
        let sec_step = options.sec_step;
        let stop_sec = options.stop;

        // Decide whether your video has large or small face
        const faceMode = options.faceMode;

        // Decide which detector to use photo or stream
        // var detector = new affdex.PhotoDetector(faceMode);
        const detector = new affdex.FrameDetector(faceMode);

        // Initialize Emotion and Expression detectors
        if (options.detect.emotions) detector.detectAllEmotions();
        if (options.detect.expressions) detector.detectAllExpressions();
        if (options.detect.emojis) detector.detectAllEmojis();
        if (options.detect.appearance) detector.detectAllAppearance();

        // Init variable to save results
        let detection_results = []; // for logging all detection results.
        if (typeof stop_sec === 'undefined' || stop_sec <= secs) {
            stop_sec = Infinity
        }

        // Get video duration and set as global variable;
        let video = document.createElement('video');
        video.src = filename;
        // video.crossOrigin = 'anonymous';
        let duration;
        // print success message when duration of video is loaded.
        video.onloadedmetadata = function () {
            duration = this.duration;
            log("#logs", "Duration has been loaded for file: " + video.src)
        };

        // Initialize detector
        log("#logs", "Initializing detector...");
        detector.start();

        //Add a callback to notify when the detector is initialized and ready for runing.
        detector.addEventListener("onInitializeSuccess", function () {
            log("#logs", "The detector reports initialized");
            getVideoImage(secs);
        });

// This portion grabs image from the video
        function getVideoImage(seconds) {
            video.currentTime = Math.min(Math.max(0, (seconds < 0 ? video.duration : 0) + seconds), video.duration);
            video.onseeked = function (e) {
                let canvas = document.createElement('canvas');
                canvas.crossOrigin = 'anonymous';
                // canvas.width = 640;
                // canvas.height = 480;

                let ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                let img = new Image();
                img.src = canvas.toDataURL();
                if (verbose) {
                    document.getElementById("logs").appendChild(img);
                    document.getElementById("logs").appendChild(document.createElement("br"));
                }
                // Pass the image to the detector to track emotions
                if (detector && detector.isRunning) {
                    log("#logs", "Processing second : ".concat(precisionRound(seconds, 3).toString()));
                    detector.process(ctx.getImageData(0, 0, canvas.width, canvas.height), seconds);
                }

            };
            video.onerror = function (e) {
                console.log("Video Seeking Error");
            };
        }

        detector.addEventListener("onImageResultsSuccess", function (faces, image, timestamp) {
            // drawImage(image);
            $('#results').html("");
            const time_key = "Timestamp";
            const time_val = timestamp;
            console.log('#results', "Timestamp: " + timestamp.toFixed(2));
            console.log('#results', "Number of faces found: " + faces.length);
            if (verbose) {
                log("#logs", "Number of faces found: " + faces.length);
            }
            if (faces.length > 0) {
                // Append timestamp
                faces[0].emotions[time_key] = time_val;
                // Save both emotions and expressions
                const json = Object.assign({}, faces[0].emotions, faces[0].expressions);
                detection_results.push(json);
            } else {
                // If face is not detected skip entry.
                console.log('Cannot find face, skipping entry');
            }

            if (duration >= secs && stop_sec >= secs) {
                secs = secs + sec_step;
                getVideoImage(secs);
            } else {
                console.log("EndofDuration");
                let report = JSON.stringify(detection_results);
                // var blob = new Blob(report, {type: "application/json"});
                if (callback) callback(report);
                // var saveAs = window.saveAs;
                // saveAs(blob, filename.split(".")[0].concat(".json"));
            }

        });

        function log(node_name, msg) {
            // Function from affectiva demo to write log on html page.
            // First var is div name, second var message.
            $(node_name).append("<span>" + msg + "</span><br />")
        }

        function precisionRound(number, precision) {
            const factor = Math.pow(10, precision);
            return Math.round(number * factor) / factor;
        }
    }

    /**
     * Analyze a real-time recording using the webcam.
     * @param {AnalysisCompletedCallback} [callback] A callback.
     * @param {Configuration} [options] The configuration of the analysis
     * @return {{start, end, reset}} A series of
     * references to functions to start, stop and reset the analysis.
     */
    static analyzeCamera(callback = undefined, options = undefined) {
        if (options === undefined) {
            options = EmotionAnalysis.getDefaultConfiguration();
        } else {
            options = _.assign({}, EmotionAnalysis.getDefaultConfiguration(), options);
        }

        // SDK Needs to create video and canvas nodes in the DOM in order to function
        // Here we are adding those nodes a predefined div.
        let divRoot = $("#affdex_elements")[0];
        let width = 640;
        let height = 480;
        const faceMode = options.faceMode;
        //Construct a CameraDetector and specify the image width / height and face detector mode.
        const detector = new affdex.CameraDetector(divRoot, width, height, faceMode);

        let detection_results = [];

        //Enable detection of all Expressions, Emotions and Emojis classifiers.
        if (options.detect.emotions) detector.detectAllEmotions();
        if (options.detect.expressions) detector.detectAllExpressions();
        if (options.detect.emojis) detector.detectAllEmojis();
        if (options.detect.appearance) detector.detectAllAppearance();

        //Add a callback to notify when the detector is initialized and ready for runing.
        detector.addEventListener("onInitializeSuccess", function () {
            log('#logs', "The detector reports initialized");
            //Display canvas instead of video feed because we want to draw the feature points on it
            $("#face_video_canvas").css("display", "block");
            $("#face_video").css("display", "none");
        });

        function log(node_name, msg) {
            console.log(msg);
        }

        //function executes when Start button is pushed.
        function onStart() {
            if (detector && !detector.isRunning) {
                detector.start();
            }
            log('#logs', "Clicked the start button");
        }

        //function executes when the Stop button is pushed.
        function onStop() {
            log('#logs', "Clicked the stop button");
            if (detector && detector.isRunning) {
                detector.removeEventListener();
                detector.stop();
            }
            callback(detection_results);
        }

        //function executes when the Reset button is pushed.
        function onReset() {
            log('#logs', "Clicked the reset button");
            if (detector && detector.isRunning) {
                detector.reset();
                // $('#results').html("");
            }
            detection_results = [];
        }

        //Add a callback to notify when camera access is allowed
        detector.addEventListener("onWebcamConnectSuccess", function () {
            log('#logs', "Webcam access allowed");
        });

        //Add a callback to notify when camera access is denied
        detector.addEventListener("onWebcamConnectFailure", function (er) {
            console.log("Webcam access denied" + er);
        });

        //Add a callback to notify when detector is stopped
        detector.addEventListener("onStopSuccess", function () {
            log('#logs', "The detector reports stopped");
        });

        //Add a callback to receive the results from processing an image.
        //The faces object contains the list of the faces detected in an image.
        //Faces object contains probabilities for all the different expressions, emotions and appearance metrics
        detector.addEventListener("onImageResultsSuccess", function (faces, image, timestamp) {
            // $('#results').html("");
            log('#results', "Timestamp: " + timestamp.toFixed(2));
            log('#results', "Number of faces found: " + faces.length);
            if (faces.length > 0) {
                // detection_results = faces[0];
                let json = Object.assign({}, faces[0].emotions, faces[0].expressions);
                // log('#results', "Appearance: " + JSON.stringify(faces[0].appearance));
                // log('#results', "Emotions: " + JSON.stringify(faces[0].emotions, function (key, val) {
                //     return val.toFixed ? Number(val.toFixed(0)) : val;
                // }));
                // log('#results', "Expressions: " + JSON.stringify(faces[0].expressions, function (key, val) {
                //     return val.toFixed ? Number(val.toFixed(0)) : val;
                // }));
                // log('#results', "Emoji: " + faces[0].emojis.dominantEmoji);
                // if ($('#face_video_canvas')[0] != null) {
                //     drawFeaturePoints(image, faces[0].featurePoints);
                // }
                detection_results.push(json)
            }
        });

        //Draw the detected facial feature points on the image
        // function drawFeaturePoints(img, featurePoints) {
        //     let contxt = $('#face_video_canvas')[0].getContext('2d');
        //
        //     // let hRatio = contxt.canvas.width / img.width;
        //     // let vRatio = contxt.canvas.height / img.height;
        //     // let ratio = Math.min(hRatio, vRatio);
        //
        //     contxt.strokeStyle = "#FFFFFF";
        //     for (let id in featurePoints) {
        //         contxt.beginPath();
        //         contxt.arc(featurePoints[id].x,
        //             featurePoints[id].y, 2, 0, 2 * Math.PI);
        //         contxt.stroke();
        //
        //     }
        // }

        return {
            start: onStart,
            reset: onReset,
            stop: onStop
        };
    }

    /**
     * Get the average report from a report
     * @param {Object} reports The report
     * @returns {{engagement: number, chinRaise: number, sadness: number, anger: number, Timestamp: number, eyeClosure: number, smile: number, smirk: number, joy: number, lipCornerDepressor: number, innerBrowRaise: number, browFurrow: number, lidTighten: number, lipPress: number, browRaise: number, lipPucker: number, fear: number, surprise: number, mouthOpen: number, dimpler: number, cheekRaise: number, noseWrinkle: number, lipSuck: number, jawDrop: number, upperLipRaise: number, valence: number, lipStretch: number, contempt: number, eyeWiden: number, attention: number, disgust: number}}
     */
    static average(reports) {
        let average_report = {
            'joy': 0,
            'sadness': 0,
            'disgust': 0,
            'contempt': 0,
            'anger': 0,
            'fear': 0,
            'surprise': 0,
            'valence': 0,
            'engagement': 0,
            'Timestamp': 0,
            'smile': 0,
            'innerBrowRaise': 0,
            'browRaise': 0,
            'browFurrow': 0,
            'noseWrinkle': 0,
            'upperLipRaise': 0,
            'lipCornerDepressor': 0,
            'chinRaise': 0,
            'lipPucker': 0,
            'lipPress': 0,
            'lipSuck': 0,
            'mouthOpen': 0,
            'smirk': 0,
            'eyeClosure': 0,
            'attention': 0,
            'lidTighten': 0,
            'jawDrop': 0,
            'dimpler': 0,
            'eyeWiden': 0,
            'cheekRaise': 0,
            'lipStretch': 0
        };

        if (!Array.isArray(reports)) {
            average_report = reports;
        } else {
            reports.forEach(report => {
                if (report) {
                    Object.keys(average_report).forEach(key => {
                        average_report[key] += report[key];
                    });
                }
            });
            Object.keys(average_report).forEach(key => {
                average_report[key] /= reports.length;
            });
        }

        return average_report;
    }

    /**
     * Get the emotion values from a report
     * @param {Object|[Object]} report The report
     * @returns {*[]|*} The emotion values
     */
    static getEmotionValues(report) {
        let useful_values = {
            "joy": 0,
            "sadness": 0,
            "disgust": 0,
            "contempt": 0,
            "anger": 0,
            "fear": 0,
            "surprise": 0
        };

        if (!Array.isArray(report)) {
            Object.keys(useful_values).forEach(key => {
                useful_values[key] = report[key];
            });
            return useful_values;
        } else {
            return report.map(frame => EmotionAnalysis.getEmotionValues(frame));
        }
    }
}

window.EmotionAnalysis = EmotionAnalysis;
// exports.default = EmotionAnalysis;
// export default EmotionAnalysis;
