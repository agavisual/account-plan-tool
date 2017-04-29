<?php

/* funcion que redireciona a una pagina */

function redirec($page) {
    echo "<script language=javascript>";
    //echo "alert('$page');";
    echo "location.href = '$page';";
    echo "</script>";
}

/* function for generate letter from number as clomn name in excel */

function getNameFromNumber($num) {
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}

// function defination to convert array to xml
function array_to_xml($data, &$xml_data) {
    foreach ($data as $key => $value) {
        if (is_numeric($key)) {
            $key = 'item' . $key; //dealing with <0/>..<n/> issues
        }
        if (is_array($value)) {
            $subnode = $xml_data->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key", htmlspecialchars("$value"));
        }
    }
}

/*
  esta funcion se usa para setear el encabezado del grup de business unit
 *  
 */

function getGroupHeader($legal_name, $industry, $website, $address, $phone, $description, $segment) {
    $html = '<div class="unit-header">
                <ul class="features">
                    <li>P?</li>
                    <li>0</li>
                    <li>?</li>
                </ul>
                <div class="priority">
                    <img src="public/image/star.svg">
                    <img src="public/image/star.svg">
                    <img src="public/image/star.svg">
                </div>        
                <div class="title">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 50 50" enable-background="new 0 0 50 50" xml:space="preserve">
                        <path fill="#585D61" d="M48.1,15.4C44.2,6.1,35.2,0,25,0C14.2,0,4.7,6.9,1.3,17.1C0.4,19.6,0,22.3,0,25c0,13.8,11.2,25,25,25
                              s25-11.2,25-25C50,21.7,49.4,18.5,48.1,15.4z M25,2.6c8.6,0,16.4,4.9,20.1,12.6l-2.6,1.1C39.2,9.7,32.5,5.5,25,5.5
                              c-8.1,0-15.2,4.9-18.1,12.3l-2.7-1C7.6,8.3,15.8,2.6,25,2.6z M25,41.9c-9.3,0-16.9-7.6-16.9-16.9c0-1.7,0.3-3.5,0.8-5.1
                              c2.2-7,8.7-11.8,16.1-11.8c6.9,0,13,4.1,15.6,10.4c0.8,2,1.3,4.2,1.3,6.4C41.9,34.3,34.3,41.9,25,41.9z M2.6,25c0-2,0.3-3.9,0.8-5.7
                              l2.7,1c-0.4,1.5-0.6,3.1-0.6,4.7c0,10.3,8,18.8,18.2,19.4v2.9C12,46.6,2.6,36.9,2.6,25z M26.3,47.3v-2.9
                              c10.1-0.7,18.2-9.1,18.2-19.4c0-2.1-0.4-4.2-1-6.2l2.6-1.1c0.8,2.3,1.2,4.8,1.2,7.3C47.4,36.9,38,46.6,26.3,47.3z"></path>

                        <circle fill="' . getSegmentColor(str_replace("&", "", str_replace("amp;", "", htmlspecialchars($segment)))) . '" cx="25" cy="25" r="16.9"></circle>
                    </svg>
                    <h3>' . $legal_name . '</h3>
                </div>

                <div class="row1">
                    <img src="public/image/info.svg"><h4>Information</h4>
                    <p><span>Industry: </span>' . $industry . '. <span>Website: </span> ' . $website . '. <span>Adress: </span> ' . $address . '. <span>Phone: </span> ' . $phone . '. <span>Description: </span> ' . $description . '. </p>
                </div>

                <div class="row2">
                    <img src="public/image/key.svg"><h4 class="icon-key">Key Decision Marker</h4>
                    <div class="unit-prio">';
    $contactos = FileDetail1::findByLegalName(str_replace("&", "",str_replace("amp;", "", htmlspecialchars($legal_name))));
    foreach ($contactos as $contact) {
        $html .= '<div class=' . ($contact->prio == "2" ? "prio2" : "prio1") . '>
                                    <div class="info">
                                        <p>' . $contact->salutation . " " . $contact->first_name . " " . $contact->last_name . '</p>
                                        <p>' . $contact->position . ' </p>
                                        <p>' . $contact->email1 . ' </p>
                                        <p>' . $contact->linkedin . '</p>
                                    </div>
                                    <div class="special">
                                        <p><span>Status: </span></p>
                                    </div>
                                    <div class="vp">
                                        <p><span>VP: </span></p>
                                    </div>
                                 </div>';
    }
    $html .= '</div>
                </div>
            </div>';

    return $html;
}

function getSegmentColor($segment) {

    $array[str_replace("&", "", 'Containers & Packaging')] = "#BEBD7F";
    $array[str_replace("&", "", 'Paper & Forest Products')] = "#C6A664";
    $array['Chemicals'] = "#E5BE01";
    $array['Construction Materials'] = "#A98307";
    $array[str_replace("&", "", 'Metals & Mining')] = "#E4A010";
    $array[str_replace("&", "", 'Automobiles & Auto Parts')] = "#8A6642";
    $array[str_replace("&", "", 'Homebuilding & Construction Supplies')] = "#EAE6CA";
    $array['Household Goods'] = "#E1CC4F";
    $array['Leisure Products'] = "#EDFF21";
    $array[str_replace("&", "", 'Textiles & Apparel')] = "#F5D033";
    $array[str_replace("&", "", 'Hotels & Entertainment Services')] = "#9E9764";
    $array[str_replace("&", "", 'Media & Publishing')] = "#9D9101";
    $array['Diversified Retail'] = "#F4A900";
    $array['Other Specialty Retailers'] = "#EFA94A";
    $array['Beverages'] = "#705335";
    $array[str_replace("&", "", 'Food & Tobacco')] = "#ED760E";
    $array[str_replace("&", "", 'Food & Drug Retailing')] = "#CB2821";
    $array[str_replace("&", "", 'Personal & Household Products & Services')] = "#F44611";
    $array['Coal'] = "#FF3798";
    $array[str_replace("&", "", 'Oil & Gas')] = "#F54021";
    $array[str_replace("&", "", 'Oil & Gas Related Equipment and Services')] = "#EC7C26";
    $array['Renewable Energy'] = "#E55137";
    $array['Uranium'] = "#C35831";
    $array['Banking Services'] = "#9B111E";
    $array[str_replace("&", "", 'Investment Banking & Investment Services')] = "#5E2129";
    $array['Collective Investments '] = "#C1876B";
    $array['Holding Companies'] = "#D36E70";
    $array['Insurance'] = "#EA899A";
    $array['Real Estate Operations'] = "#E63244";
    $array[str_replace("&", "", 'Residential & Commercial REIT')] = "#CC0605";
    $array[str_replace("&", "", 'Healthcare Equipment & Supplies')] = "#FE0000";
    $array[str_replace("&", "", 'Healthcare Providers & Services')] = "#C51D34";
    $array[str_replace("&", "", 'Biotechnology & Medical Research')] = "#6D3F5B";
    $array['Pharmaceuticals'] = "#DE4C8A";
    $array[str_replace("&", "", 'Construction & Engineering')] = "#CF3476";
    $array[str_replace("&", "", 'Diversified Trading & Distributing')] = "#8673A1";
    $array[str_replace("&", "", 'Professional & Commercial Services')] = "#1D1E33";
    $array['Industrial Conglomerates'] = "#1E2460";
    $array[str_replace("&", "", 'Aerospace & Defense')] = "#3E5F8A";
    $array[str_replace("&", "", 'Machinery, Equipment & Components')] = "#025669";
    $array[str_replace("&", "", 'Freight & Logistics Services')] = "#3B83BD";
    $array['Passenger Transportation Services'] = "#2271B3";
    $array['Transport Infrastructure'] = "#3F888F";
    $array[str_replace("&", "", 'Software & IT Services')] = "#5D9B9B";
    $array[str_replace("&", "", 'Communications & Networking')] = "#316650";
    $array[str_replace("&", "", 'Computers, Phones & Household Electronics')] = "#287233";
    $array[str_replace("&", "", 'Electronic Equipment & Parts')] = "#424632";
    $array['Office Equipment'] = "#35682D";
    $array[str_replace("&", "", 'Semiconductors & Semiconductor Equipment')] = "#1E5945";
    $array['Telecommunications Services'] = "#57A639";
    $array[str_replace("&", "", 'Electrical Utilities & IPPs')] = "#BDECB6";
    $array['Multiline Utilities'] = "#89AC76";
    $array['Natural Gas Utilities'] = "#3D642D";
    $array['Water Utilities'] = "#84C3BE";
    $array['Executive, Legislative, and Other General Government Support'] = "#00BB2D";
    $array['Justice, Public Order, and Safety Activities'] = "#78858B";
    $array['Administration of Human Resource Programs'] = "#8A9597";
    $array['Administration of Environmental Quality Programs'] = "#7E7B52";
    $array['Administration of Housing Programs, Urban Planning, and Community Development'] = "#646B63";
    $array['Administration of Economic Programs'] = "#B8B799";
    $array['Space Research and Technology'] = "#955F20";
    $array['Applied Resources'] = "#6D3F5B";
    $array[str_replace("&", "", 'Automobiles & Auto Parts')] = "#78858B";
    $array[str_replace("&", "", 'Banking & Investment Services')] = "#ffcc80";
    $array['Basic Materials'] = "#BEBD7F";
    $array['Chemicals'] = "#84C3BE";
    $array['Collective Investments'] = "#CF3476";
    $array['Consumer Cyclicals'] = "#9B111E";
    $array['Consumer Non-Cyclicals'] = "#EDFF21";
    $array['Cyclical Consumer Products'] = "#c5e1a5";
    $array['Cyclical Consumer Services'] = "#1E2460";
    $array['Energy'] = "#1D1E33";
    $array['Energy - Fossil Fuels'] = "#316650";
    $array['Financials'] = "#69f0ae";
    $array[str_replace("&", "", 'Food & Beverages')] = "#3B83BD";
    $array[str_replace("&", "", 'Food & Drug Retailing')] = "#C6A664";
    $array['Healthcare'] = "#1E5945";
    $array['Healthcare Services'] = "#FF3798";
    $array['Holding Companies'] = "#ef9a9a";
    $array[str_replace("&", "", 'Industrial & Commercial Services')] = "#b0bec5";
    $array['Industrial Conglomerates'] = "#8E402A";
    $array['Industrial Goods'] = "#F5D033";
    $array['Industrials'] = "#D36E70";
    $array['Insurance'] = "#90caf9";
    $array['Mineral Resources'] = "#eeeeee";
    $array[str_replace("&", "", 'Personal & Household Products & Services')] = "#424632";
    $array[str_replace("&", "", 'Pharmaceuticals & Medical Research')] = "#35682D";
    $array['Real Estate'] = "#7E7B52";
    $array['Renewable Energy'] = "#EA899A";
    $array['Retailers'] = "#2271B3";
    $array[str_replace("&", "", 'Software & IT Services')] = "#CC0605";
    $array['Technology'] = "#B8B799";
    $array['Technology Equipment'] = "#BDECB6";
    $array['Telecommunications Services'] = "#8673A1";
    $array['Transportation'] = "#89AC76";
    $array['Uranium'] = "#955F20";
    $array['Utilities'] = "#fff59d";

    //echo "<p>".$segment."</p>";


    $str_segment = str_replace("&", "", $segment); //trim(str_replace(' &amp;amp;', '&', $segment));
    //echo "<p>segmento final : ". $str_segment ."  </p>";  // <span style='background-color:".$array[$segment].";'></span>    

    return (isset($array[$str_segment]) ? $array[$str_segment] : "");
    //return $array[$str_segment];
}

function getCountryColor($num) {
    $array[] = 'rgba(3, 169, 244, 0.2)';
    $array[] = 'rgba(244, 67, 54, 0.2)';
    $array[] = 'rgba(33, 150, 243, 0.2)';
    $array[] = 'rgba(103, 58, 183, 0.2)';
    $array[] = 'rgba(0, 150, 136, 0.2)';
    $array[] = 'rgba(139, 195, 74, 0.2)';
    $array[] = 'rgba(156, 39, 176, 0.2)';
    $array[] = 'rgba(205, 220, 57, 0.2)';
    $array[] = 'rgba(255, 193, 7, 0.2)';
    $array[] = 'rgba(76, 175, 80, 0.2)';
    $array[] = 'rgba(158, 158, 158, 0.2)';
    $array[] = 'rgba(255, 87, 34, 0.2)';
    $array[] = 'rgba(96, 125, 139, 0.2)';
    $array[] = 'rgba(255, 152, 0, 0.2)';
    $array[] = 'rgba(233, 30, 99, 0.2)';
    $array[] = 'rgba(121, 85, 72, 0.2)';
    $array[] = 'rgba(96, 125, 139, 0.2)';
    $array[] = 'rgba(255, 235, 59, 0.2)';
    $array[] = 'rgba(0, 200, 83, 0.2)';
    $array[] = 'rgba(213, 0, 0, 0.2)';
    

    return $array[$num];
}

function getCountryColor2($num2) {
    $array[] = 'rgba(129, 212, 250, 0.2)';
    $array[] = 'rgba(239, 154, 154, 0.2)';
    $array[] = 'rgba(144, 202, 249, 0.2)';
    $array[] = 'rgba(63,  81,  181, 0.2)';
    $array[] = 'rgba(128, 203, 196, 0.2)';
    $array[] = 'rgba(197, 225, 165, 0.2)';
    $array[] = 'rgba(206, 147, 216, 0.2)';
    $array[] = 'rgba(230, 238, 156, 0.2)';
    $array[] = 'rgba(255, 224, 130, 0.2)';
    $array[] = 'rgba(165, 214, 167, 0.2)';
    $array[] = 'rgba(238, 238, 238, 0.2)';
    $array[] = 'rgba(255, 171, 145, 0.2)';
    $array[] = 'rgba(176, 190, 197, 0.2)';
    $array[] = 'rgba(255, 204, 128, 0.2)';
    $array[] = 'rgba(244, 143, 177, 0.2)';
    $array[] = 'rgba(188, 170, 164, 0.2)';
    $array[] = 'rgba(176, 190, 197, 0.2)';
    $array[] = 'rgba(255, 245, 157, 0.2)';
    $array[] = 'rgba(105, 240, 174, 0.2)';
    $array[] = 'rgba(255, 82, 82, 0.2)';

    return $array[$num2];
}

//function to get color of the country
function getCountryColor11111111($country) {

    $array[str_replace("&", "", 'Applied Resources')] = '#6D3F5B';
    $array[str_replace("&", "", 'Automobiles & Auto Parts')] = '#78858B';
    $array[str_replace("&", "", 'Banking & Investment Services')] = '#ffcc80';
    $array[str_replace("&", "", 'Basic Materials')] = '#BEBD7F';
    $array[str_replace("&", "", 'Chemicals')] = '#84C3BE';
    $array[str_replace("&", "", 'Collective Investments')] = '#CF3476';
    $array[str_replace("&", "", 'Consumer Cyclicals')] = '#9B111E';
    $array[str_replace("&", "", 'Consumer Non-Cyclicals')] = '#EDFF21';
    $array[str_replace("&", "", 'Cyclical Consumer Products')] = '#c5e1a5';
    $array[str_replace("&", "", 'Cyclical Consumer Services')] = '#1E2460';
    $array[str_replace("&", "", 'Energy')] = '#1D1E33';
    $array[str_replace("&", "", 'Energy - Fossil Fuels')] = '#316650';
    $array[str_replace("&", "", 'Financials')] = '#69f0ae';
    $array[str_replace("&", "", 'Food & Beverages')] = '#3B83BD';
    $array[str_replace("&", "", 'Food & Drug Retailing')] = '#C6A664';
    $array[str_replace("&", "", 'Healthcare')] = '#1E5945';
    $array[str_replace("&", "", 'Healthcare Services')] = '#FF3798';
    $array[str_replace("&", "", 'Holding Companies')] = '#ef9a9a';
    $array[str_replace("&", "", 'Industrial & Commercial Services')] = '#b0bec5';
    $array[str_replace("&", "", 'Industrial Conglomerates')] = '#8E402A';
    $array[str_replace("&", "", 'Industrial Goods')] = '#F5D033';
    $array[str_replace("&", "", 'Industrials')] = '#D36E70';
    $array[str_replace("&", "", 'Insurance')] = '#90caf9';
    $array[str_replace("&", "", 'Mineral Resources')] = '#eeeeee';
    $array[str_replace("&", "", 'Personal & Household Products & Services')] = '#424632';
    $array[str_replace("&", "", 'Pharmaceuticals & Medical Research')] = '#35682D';
    $array[str_replace("&", "", 'Real Estate')] = '#7E7B52';
    $array[str_replace("&", "", 'Renewable Energy')] = '#EA899A';
    $array[str_replace("&", "", 'Retailers')] = '#2271B3';
    $array[str_replace("&", "", 'Software & IT Services')] = '#CC0605';
    $array[str_replace("&", "", 'Technology')] = '#B8B799';
    $array[str_replace("&", "", 'Technology Equipment')] = '#BDECB6';
    $array[str_replace("&", "", 'Telecommunications Services')] = '#8673A1';
    $array[str_replace("&", "", 'Transportation')] = '#89AC76';
    $array[str_replace("&", "", 'Uranium')] = '#955F20';
    $array[str_replace("&", "", 'Utilities')] = '#fff59d';

    $str_contry = str_replace("&", "", $country); //trim(str_replace(' &amp;amp;', '&', $segment));
    //echo "<p>segmento final : ". $str_segment ."  </p>";  // <span style='background-color:".$array[$segment].";'></span>    

    return (isset($array[$str_country]) ? $array[$str_country] : "");
}
?>

