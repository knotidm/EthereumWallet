pragma solidity ^0.4.18;

contract GreatContract {
    address private contractOwner;
    uint256 tokenPrice;
    uint256 public numberOfAllTokens;
    uint256 public numberOfAvailableTokens;
    uint256 public numberOfSoldTokens;
    mapping(address => uint256) private purchasers;

    function GreatContract() public {
        contractOwner = msg.sender;
        tokenPrice = 0.79 ether;
        numberOfAllTokens = 12;
        numberOfAvailableTokens = numberOfAllTokens;
        numberOfSoldTokens = 0;
    }

    function() public payable {
        uint256 amount = msg.value / tokenPrice;
        require(amount <= numberOfAvailableTokens);
        purchasers[msg.sender] += amount;
        numberOfSoldTokens += amount;
        numberOfAvailableTokens -= amount;
    }

    modifier OnlyContractOwner{
        require(msg.sender == contractOwner);
        _;
    }

    function getNumberOfAllTokens() public constant returns (uint256) {
        return numberOfAllTokens;
    }

    function getNumberOfTokens(address _address) public constant returns (uint256) {
        return purchasers[_address];
    }

    function getContractOwner() public constant returns (address) {
        return (contractOwner);
    }

    function getTokenPrice() public constant returns (uint256) {
        return (tokenPrice);
    }

    function setTokenPrice(uint256 value) public OnlyContractOwner {
        tokenPrice = value;
    }

    function setNumberOfAllTokens(uint256 value) public OnlyContractOwner {
        numberOfAllTokens = value;
        numberOfAvailableTokens = numberOfAllTokens - numberOfSoldTokens;
    }
}